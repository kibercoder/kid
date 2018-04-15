
/**
 * Comment plugin
 */
(function ($) {

    $.fn.new_comment = function (method) {
        if (new_methods[method]) {
            return new_methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
        } else if (typeof method === 'object' || !method) {
            return new_methods.init.apply(this, arguments);
        } else {
            $.error('Method ' + method + ' does not exist on jQuery.comment');
            return false;
        }
    };

    // Default settings
    var new_defaults = {
        toolsSelector: '.comment-action-buttons',
        formSelector: '#new-comment-form',
        formContainerSelector: '.new-comment-form-container',
        contentSelector: '.comment-body',
        cancelReplyBtnSelector: '#cancel-reply',
        pjaxContainerId: '#comment-pjax-container',
        pjaxSettings: {
            timeout: 10000,
            scrollTo: false,
            url: window.location.href
        },
        submitBtnText: 'Comment',
        submitBtnLoadingText: 'Loading...'
    };

    var new_commentData = {};

    // Methods
    var new_methods = {
        init: function (options) {
            return this.each(function () {
                var $comment = $(this);
                var settings = $.extend({}, new_defaults, options || {});
                var id = $comment.attr('id');
                if (new_commentData[id] === undefined) {
                    new_commentData[id] = {};
                } else {
                    return;
                }
                new_commentData[id] = $.extend(new_commentData[id], {settings: settings});

                var formSelector = new_commentData[id].settings.formSelector;
                var eventParams = {formSelector: formSelector, wrapperSelector: id};

                $comment.on('beforeSubmit.comment', formSelector, eventParams, new_createComment);
                //$comment.on('click.comment', '[data-action="reply"]', eventParams, reply);
                $comment.on('click.comment', '[data-action="cancel-reply"]', eventParams, cancelReply);
                //$comment.on('click.comment', '[data-action="delete"]', eventParams, deleteComment);
            });
        },
        data: function () {
            var id = $(this).attr('id');
            return new_commentData[id];
        }
    };


    /**
     * Create a comment
     * @returns {boolean}
     */
    function new_createComment(event) {
        var $commentForm = $(this);
        var settings = new_commentData[event.data.wrapperSelector].settings;
        var pjaxSettings = $.extend({container: settings.pjaxContainerId}, settings.pjaxSettings);
        var formData = $commentForm.serializeArray();
        formData.push({'name': 'CommentModel[url]', 'value': getCurrentUrl()});
        // disable submit button
        $commentForm.find(':submit').prop('disabled', true).text(settings.submitBtnLoadingText);
        // creating a comment and errors handling
        $.post($commentForm.attr('action'), formData, function (data) {
            if (data.status == 'success') {
                $.pjax(pjaxSettings);
            }
            // errors handling
            else {
                if (data.hasOwnProperty('errors')) {
                    $commentForm.yiiActiveForm('updateMessages', data.errors, true);
                }
                else {
                    $commentForm.yiiActiveForm('updateAttribute', 'commentmodel-content', [data.message]);
                }
                // enable submit button
                $commentForm.find(':submit').prop('disabled', false).text(settings.submitBtnText);
            }
        }).fail(function (xhr, status, error) {
            alert(error);
            $.pjax(pjaxSettings);
        });

        return false;
    }

    /**
     * Reply to comment
     * @param event
     */
    function reply(event) {
        var $this = $(this);
        var $commentForm = $(event.data.formSelector);
        var settings = new_commentData[event.data.wrapperSelector].settings;
        var parentCommentSelector = $this.parents('[data-comment-content-id="' + $this.data('comment-id') + '"]');
        // append the comment form inside particular comment container
        $commentForm.appendTo(parentCommentSelector);
        $commentForm.find('[data-comment="parent-id"]').val($this.data('comment-id'));
        $commentForm.find(settings.cancelReplyBtnSelector).show();

        return false;
    }

    /**
     * Cancel reply
     * @param event
     */
    function cancelReply(event) {
        var $commentForm = $(event.data.formSelector);
        var settings = new_commentData[event.data.wrapperSelector].settings;
        var formContainer = $(settings.pjaxContainerId).find(settings.formContainerSelector);
        // prepend the comment form to `formContainer`
        $commentForm.find(settings.cancelReplyBtnSelector).hide();
        $commentForm.prependTo(formContainer);
        $commentForm.find('[data-comment="parent-id"]').val(null);

        return false;
    }

    /**
     * Delete a comment
     * @param event
     */
    function deleteComment(event) {
        var $this = $(this);
        var settings = new_commentData[event.data.wrapperSelector].settings;

        $.ajax({
            url: $this.data('url'),
            type: 'DELETE',
            error: function (xhr, status, error) {
                alert(error);
            },
            success: function (result, status, xhr) {
                $this.parents('[data-comment-content-id="' + $this.data('comment-id') + '"]').find(settings.contentSelector).text(result);
                $this.parents(settings.toolsSelector).remove();
            }
        });

        return false;
    }

    /**
     * Get current url without `hostname`
     * @returns {string}
     */
    function getCurrentUrl() {
        return window.location.pathname + window.location.search;
    }

})(window.jQuery);




jQuery(function ($) {

id_comment = $('.comment-wrapper').attr('id');

jQuery('#'+id_comment).new_comment({"pjaxContainerId":"#comment-pjax-container-w0","formSelector":"#new-comment-form"});


jQuery('#new-comment-form').yiiActiveForm([{"id":"commentmodel-content","name":"content","container":".field-commentmodel-content","input":"#commentmodel-content","validateOnChange":false,"validateOnBlur":false,"validate":function (attribute, value, messages, deferred, $form) {yii.validation.required(value, messages, {"message":"Комментарий не может быть пустым."});yii.validation.string(value, messages, {"message":"Значение «Комментарий» должно быть строкой.","skipOnEmpty":1});}},{"id":"commentmodel-parentid","name":"parentId","container":".field-commentmodel-parentid","input":"#commentmodel-parentid","validateOnChange":false,"validateOnBlur":false,"validate":function (attribute, value, messages, deferred, $form) {yii.validation.number(value, messages, {"pattern":/^\s*[+-]?\d+\s*$/,"message":"Значение «Родитель» должно быть целым числом.","skipOnEmpty":1});}}], []);


jQuery(document).pjax("#comment-pjax-container-w0 a", {"push":false,"replace":false,"timeout":20000,"scrollTo":false,"container":"#comment-pjax-container-w0"});
jQuery(document).on("submit", "#comment-pjax-container-w0 form[data-pjax]", function (event) {jQuery.pjax.submit(event, {"push":false,"replace":false,"timeout":20000,"scrollTo":false,"container":"#comment-pjax-container-w0"});});
});
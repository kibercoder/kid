<?php

  //Вставляем JS код прямо в шаблоне - этот код будет работать в связке с Jquery
  $this->registerJs(
    '$(function(){

    });'
  );
?>

<style type="text/css">
	path {fill: lightgray; stroke: white;}
    path:hover {fill: gray !important;}
</style>

<svg enable_background="new 0 0 1000 647" height="647px" pretty_print="False" style="stroke-linejoin: round; stroke:#000; fill: none;" version="1.1" viewBox="0 0 1000 647" width="1000px" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
<defs>
<style type="text/css"><![CDATA[path { fill-rule: evenodd; }]]></style></defs><metadata>
  <views>
    <view h="647.825177808" padding="0" w="1000">
      <proj flip="auto" id="mercator" lon0="65.3146660706"/>
      <bbox h="4064.12" w="6283.19" x="-3141.59" y="-2891.13"/>
    </view>
  </views>
</metadata>

<g class="" id="countries">

<?php

	foreach ($map as $key => $country) {

echo <<<COUNTRY

<path style="fill: {$country[fill_color]};" d="{$country[coordinates]}" data-id="{$country[short_name]}" data-name="{$country[country]}" id="{$country[short_name]}" data-engname="{$country[country_en]}" />

COUNTRY;

	}

?>

</g></svg>


<script type="text/javascript">
	
    // <![CDATA[
    var countryElements = document.getElementById('countries').childNodes;
    var countryCount = countryElements.length;
    for (var i = 0; i < countryCount; i++) {
      countryElements[i].onclick = function() {
        alert('Вы выбрали ' + this.getAttribute('data-name'));
      }
    }
    // ]]>

</script>
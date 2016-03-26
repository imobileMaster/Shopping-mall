<table style="border:solid 1px #999;border-collapse: collapse; width:100%;" id=tbl_spec name=tbl_spec>
    <tr><TD style='border:solid 1px #999; text-align:left; text-indent:10px; font-weight:bold;' colSpan=2 id='rightTitle'>主体</TD></tr>
<?php
    $productDetailInfoArray = explode("@@@EXE@@@", $productDetailInfo);
    for($i=0; $i<count($productDetailInfoArray); $i++){
        $productInputDetailInfo = $productDetailInfoArray[$i];
        $productInputDetailInfoArray = explode("###EXE###", $productInputDetailInfo);
        if(count($productInputDetailInfoArray)==1) echo "<tr><TD style='border:solid 1px #999; text-align:left; text-indent:10px; font-weight:bold;' colSpan=2 id='rightTitle'>".$productInputDetailInfoArray[0]."</TD></tr>";
        else{
			echo "<tr><td style='border:solid 1px #999;width:100px' id='rightTitle'>".$productInputDetailInfoArray[0]."&nbsp;</td><td style='border:solid 1px #999;width:700px' id='leftContent'>";
			echo $productInputDetailInfoArray[1];
			echo "</td></tr>";
        }
    }
?>
</table>
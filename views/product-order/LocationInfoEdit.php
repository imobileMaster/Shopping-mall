<script language="javascript">
    $("#prov").html('<option value="-1" selected="">请选择</option><?php for($i=0; $i<count($regionCodeArray); $i++){?><option value="<?=$regionCodeArray[$i]['regionIndex']?>" <?php if(count($rgnCodeArr)>0){if($rgnCodeArr[0]==$regionCodeArray[$i]['regionIndex']) echo "SELECTED";}?>><?=$regionCodeArray[$i]['regionID']?></option><?php }?>');
    $("#city").html('<option value="-1" selected="">请选择</option><?php if(count($rgnCodeArr)>0){$regionCodeArray = $procRegionObj->GetChildClass($rgnCodeArr[0]);for($i=0; $i<count($regionCodeArray); $i++){?><option value="<?=$regionCodeArray[$i]['regionIndex']?>" <?php if(count($rgnCodeArr)>1){if($rgnCodeArr[1]==$regionCodeArray[$i]['regionIndex']) echo "SELECTED";}?>><?=$regionCodeArray[$i]['regionID']?></option><?php }}?>');
    $("#county").html('<option value="-1" selected="">请选择位置</option>
    <?php
        if(count($rgnCodeArr) > 1){
            $regionCodeArray = $procRegionObj->GetChildClass($rgnCodeArr[1]);
            for($i=0; $i<count($regionCodeArray); $i++){
    ?>
    <option value="<?=$regionCodeArray[$i]['regionIndex']?>"
    <?php
        if(count($rgnCodeArr) > 2){
            if($rgnCodeArr[2] == $regionCodeArray[$i]['regionIndex'])
                echo "SELECTED";
        }
    ?>
    <?=$regionCodeArray[$i]['regionID']?></option>
    <?php
    }
    }?>');
</script>


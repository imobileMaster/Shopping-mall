<?php 
    if(isset($addStyle)&&($addStyle)){?>
        <STYLE>
            .navBar1 {height: 24px; line-height: 24px;margin-bottom:3px;} 
            .navBar1 a.currPage {background: #BBB;border: none;color: #F60;font-weight: bold;text-decoration: none;}.navBar1 a, .navBar1 span {background: #DDD;border: 1px solid #CCC;display:block; float:left; font-family: Arial;font-size: 14px;height: 24px;line-height: 24px;margin-left: 3px;overflow: hidden;padding: 0px 7px;}    
            .navBar1 a{color: mediumblue; text-decoration:none;}    
            .navBar1 a:hover {background: #6E7DD8;color: white;text-decoration: none;}
        </STYLE>
<?php }

    $Pm = 2;                                                                    // List Page Items = 2 * Pm + 1
    $Pt = ($numResult - 1 - ($numResult - 1) % $n) / $n + 1;                                    // Total Page Number
    $minL = max(1, $curPage - $Pm);
    $maxL = min($Pt, $curPage + $Pm);
    $diff = 2 * $Pm - $maxL + $minL;

    if($diff) 
        $minL = max(1, $minL - $diff);
    
    $diff = 2 * $Pm - $maxL + $minL;
    
    if($diff) 
        $maxL = min($Pt, $maxL + $diff);
    
    $diff = 2 * $Pm - $maxL + $minL;

    if($Pt > 1)
    {
        if(isset($addStyle)&&($addStyle))
        {
            echo '<div class="navSec"> <div class="navBar1">';
        }
        else
        {
            echo '<div class="navBar5">';
        }
        if($Pt > 1){
            if(!isset($curClass)) 
                $curClass = "currPage";
            if(($curPage != 1)&&($minL > 2)) 
                echo '<a href="javascript: void(0);" value="'.($curPage-1).'">上一页</a>';
            if($diff){                                                                                  
                for($i = $minL; $i<=$maxL; $i++){
                    if($i == $curPage) 
                        echo '<a href="javascript:void(0)" class="'.$curClass.'" value="0">'.$curPage.'</a>';
                    else 
                        echo '<a href="javascript: void(0);" value="'.$i.'">'.$i.'</a>';
                }
            } else {
                if($minL > 1) 
                    echo '<a href="javascript: void(0);" value="1">1</a>';
                if($minL > 2) 
                    echo '<span>...</span>';
                for($i = $minL; $i<=$maxL; $i++){
                    if($i == $curPage) 
                        echo '<a href="javascript:void(0)" class="'.$curClass.'" value="0">'.$curPage.'</a>';
                    else 
                        echo '<a href="javascript: void(0);" value="'.$i.'">'.$i.'</a>';
                }
                if($maxL < $Pt - 1) 
                    echo '<span>...</span>';
                if($maxL < $Pt) 
                    echo '<a href="javascript: void(0);" value="'.$Pt.'">'.$Pt.'</a>';
            }
            if(($curPage != $Pt)&&($maxL < $Pt - 1)) 
                echo '<a href="javascript: void(0);" value="'.($curPage+1).'">下一页</a>';    
        }
        if(isset($addStyle)&&($addStyle))
        {    
            echo '</div>';
        }
        echo '</div>';
    }
?>
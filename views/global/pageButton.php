<?php
    /*
        $n: number of items per page 
    */
    
        
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

     if (!isset($floatingStyle))
        $floatingStyle = 'right';
    
    //echo "==========" . $Pt . '========' . $numResult. '=======' . $n . '=======' . $curPage;
            
    if($Pt > 1)
    {
        echo '<div class="navBar5" style="float:' . $floatingStyle . ';">';
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
        echo '</div>';
    }
?>
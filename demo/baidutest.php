<?php
$aName = array("王成","王瑞","王祥","何武昌","何睿","何好","马兴","马成栋","张相","张祥");
$aId = array(88801,11144,2345,9023,12415,88021,11145,2344,11145,0376);
foreach($aName as $k =>$val)
{
    $json[$k] = array(
        'id' => $aId[$k],
        'name' => $val
        );        
}
/**************************************************************
*
*  使用特定function对数组中所有元素做处理
*  @param  string  &$array     要处理的字符串
*  @param  string  $function   要执行的函数
*  @return boolean $apply_to_keys_also     是否也应用到key上
*  @access public
*
*************************************************************/
function arrayRecursive(&$array, $function, $apply_to_keys_also = false)
{
    static $recursive_counter = 0;
    if (++$recursive_counter > 1000) {
        die('possible deep recursion attack');
    }
    foreach ($array as $key => $value) {
        if (is_array($value)) {
            arrayRecursive($array[$key], $function, $apply_to_keys_also);
        } else {
            $array[$key] = $function($value);
        }
        if ($apply_to_keys_also && is_string($key)) {
            $new_key = $function($key);
            if ($new_key != $key) {
                $array[$new_key] = $array[$key];
                unset($array[$key]);
            }
        }
    }
    $recursive_counter--;
}
/**************************************************************
*
*  将数组转换为JSON字符串（兼容中文）
*  @param  array   $array      要转换的数组
*  @return string      转换得到的json字符串
*  @access public
*
*************************************************************/
function JSON($array) {
    arrayRecursive($array, 'urlencode', true);
    $json = json_encode($array);
    return urldecode($json);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta content="text/html;charset=utf-8" http-equiv="content-type" />
    <style type="text/css">
    .name{cursor:pointer;}
    .selected{background:#CCC;}
    .normal{background:#FFF;}
    </style>
</head>
<table align="center">
    <tr>
        <td>输入测试：</td>
        <td><input type="text" style="color:" id="neirong" onkeyup="tip(event,0)"/></td>
    </tr>
</table>
<div id="showMessage" style="border:1px #666 solid;">
</div>
<script type="text/javascript">
window.onload = function(){
    var tag = document.getElementById("showMessage");
    tag.style.display = "none";
}
function tip(event) {
    var aUserName = new Array();
    var aTempName, aUserName, tag, sVal, sHtml, mesTag, selectedTag, didTag, widths;
    var postion = new Array();
                var sId = 0;//用于给每个名字加一个id的顺序
                var whichType;//用户输入的类型，是数字呢还是中文。
                aUserName = <?php echo JSON($json); ?>;
                //aUserName = eval('(' + aTempName + ')');
                tag = document.getElementById("neirong");
                didTag = document.getElementById("did");
                //输入框坐标获取
                postion = getElementPos(tag);

                //显示div坐标调整
                mesTag = document.getElementById("showMessage");
                mesTag.style.position = "absolute";
                mesTag.style.left = postion[0]
                mesTag.style.top = postion[1];
                widths = tag.style.width + "px";
                mesTag.width = widths;
                var event = event || window.event;
                var sKeyCode = event.keyCode;
                var aShangXia = new Array(37,38,39,40);
                var isDerection;
                sVal = tag.value;
                //以enter作为用户输入结束标志
                if(13!=sKeyCode) {
                    for(var i in aShangXia) {
                        if(sKeyCode == aShangXia) {
                            isDerection = false;        
                            break;
                        }        
                        else {
                            isDerection = true;        
                        }
                    }
                    if(isDerection) {
                        sHtml = '';
                        if(""==sVal) {
                            mesTag.style.display = "none";
                            mesTag.innerHTML = sHtml;
                            return false;        
                        }
                        else {                                
                            sHtml = '<table width="146px" border="0" id="showTable">';
                            if(checkVal(sVal)) {
                                for(var i in aUserName)
                                {
                                    if(0<=aUserName[i].id.indexOf(sVal)) {
                                        sHtml = sHtml + '<tr><td class="normal" onclick="clickToChoice('+sId+')" onmouseover="changeColor(true,'+sId+')" onmouseout="changeColor(false,'+sId+')" id="p_'+sId+'" readonly="readonly">'+aUserName[i].id+'_'+aUserName[i].name+'</td></tr>';
                                        sId = sId + 1;
                                    }
                                }        
                            }
                            else {
                                for(var i in aUserName)
                                {        
                                    if(0<=aUserName[i].name.indexOf(sVal)) {
                                        sHtml = sHtml + '<tr><td class="normal" onclick="clickToChoice('+sId+')" onmouseover="changeColor(true,'+sId+')" onmouseout="changeColor(false,'+sId+')" id="p_'+sId+'" readonly="readonly">'+aUserName[i].id+'_'+aUserName[i].name+'</td></tr>';
                                        sId = sId + 1;
                                    }
                                }
                            }
                            sHtml = sHtml + '</table>';
                            if(0!=sId) {                
                                mesTag.style.display = "";
                                mesTag.innerHTML = sHtml;
                                sHtml = '';        
                            }
                            else {
                                mesTag.innerHTML = '没有结果';        
                            }
                        }
                    }
                    else
                    {
                        if(38==sKeyCode||40==sKeyCode) {
                            dance(sKeyCode,sVal,tag);
                        }                
                    }        
                }
                else {
                    if(''!=tag.value) {
                        mesTag.innerHTML = '';
                        showMessage.style.display = 'none';
                    }
                    else {
                        return false;        
                    }        
                }
            }
            function checkVal(sVal){
                var patrn = /^[0-9]/;        
                if(patrn.exec(sVal)) {
                    return true;
                }
                else {
                    return false;        
                }
            }
        //获取用户通过点击的名字
        function clickToChoice(sqnm) {
            var choicedTag, mesTag, showTag;
            choicedTag = document.getElementById("p_"+sqnm);
            mesTag = document.getElementById("neirong");
            showTag = document.getElementById("showTable");
            mesTag.value = choicedTag.innerHTML; 
            showMessage.style.display = 'none';
        }

        function dance(sKeyCode,sVal,tag) {
                var danceTag = getElementsByClassName("normal");//这个是正常的行
                var danceingTag = getElementsByClassName("selected");//这个是前一个被选中的行
                var selectedTag, lastTag, showTag, selectedVal, currentNum, initial;
                var rowNums, selectedNum = 0;
                var danceLen = danceTag.length;
                if(0 != danceingTag.length) {
                    showTag = document.getElementById("showTable");
                    rowNums = showTag.rows.length;
                    currentNum = danceingTag[0].id.split("_")[1] * 1;
                    switch(sKeyCode) {
                        case 40:
                        if(rowNums == (currentNum + 1)) {
                            selectedNum = 0;        
                        }                
                        else {
                            selectedNum = currentNum + 1;
                        }
                        break;
                        case 38:
                        if(0 == currentNum ) {
                            selectedNum = rowNums - 1;        
                        }                
                        else {
                            selectedNum = currentNum - 1;
                        }
                        break;
                    }
                }
                else {
                    switch(sKeyCode) {
                        case 40:
                        currentNum = danceTag.length - 1;
                        selectedNum = 0;
                        break;
                        case 38:
                        currentNum = 0;
                        selectedNum = danceTag.length - 1;        
                        break;
                    }        
                }
                
                lastTag        = document.getElementById("p_"+currentNum);        
                lastTag.className = "normal";
                selectedTag = document.getElementById("p_"+selectedNum);        
                selectedVal = selectedTag.innerHTML;
                selectedTag.className = "selected";
                tag.value = selectedVal;

            }
            function changeColor(type,sqnm) {
                var tag = document.getElementById("p_"+sqnm);
                if(type) {
                    tag.className = "selected";
                }
                else {
                    tag.className = "normal";        
                }        
            }

            function getElementsByClassName(n) {
                var classElements = [],allElements = document.getElementsByTagName('*');
                for (var i=0; i< allElements.length; i++ )
                {
                    if (allElements[i].className == n ) {
                                classElements[classElements.length] = allElements[i]; //某类集合
                            }
                        }
                        return classElements;
                    }

                    function getElementPos(tag) {
                        var ua = navigator.userAgent.toLowerCase();
                        var isOpera = (ua.indexOf('opera') != -1);
                var isIE = (ua.indexOf('msie') != -1 && !isOpera); // not opera spoof 
                if (tag.parentNode === null || tag.style.display == 'none') {
                    return false;
                }
                var parent = null;
                var pos = [];
                var box;
                if (tag.getBoundingClientRect)  
                {
                    box = tag.getBoundingClientRect();
                    var scrollTop = Math.max(document.documentElement.scrollTop, document.body.scrollTop);
                    var scrollLeft = Math.max(document.documentElement.scrollLeft, document.body.scrollLeft);
                    pos[0] = box.left + scrollLeft + "px";
                    pos[1] = box.bottom +scrollTop + "px";
                    return pos;
                }
            }
            </script>
        </body>
        </html>
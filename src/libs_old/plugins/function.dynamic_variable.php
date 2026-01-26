<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty {dynamic_variable } function plugin
 *
 * Type:     function<br>
 * Name:     dynamic_variable<br>
 * Purpose:  evaluate a dynamic variable as a template<br>
 * @author Debopam Majilya 
 * @param array
 * @param Smarty
 */
function smarty_function_dynamic_variable($params, &$smarty)
{
	require_once $smarty->_get_plugin_filepath('shared','escape_special_chars');
	
	foreach($params as $_key => $_val) {
        switch($_key) {
            case 'string':
                $string = (string)$_val;
                break;
            
            case 'variable':
                $variable = (string)$_val;
                break;
				
			case 'rule':
                $rule = (string)$_val;
                break;
            
            default:
                $string = (string)$_val;
                break;
        }
    }
	
	if($rule == "" or $rule == "STV"){
		$var = "$".$string.$variable;
	}
	else{
		$var = "$".$variable.$string;
	}
	
	$smarty->_compile_source('evaluated template', $var, $_var_compiled);

    ob_start();
    $smarty->_eval('?>' . $_var_compiled);
    $_contents = ob_get_contents();
    ob_end_clean();
	
	$var = "{".$_contents."}";
	
	$smarty->_compile_source('evaluated template', $var, $_var_compiled);
	ob_start();
    $smarty->_eval('?>' . $_var_compiled);
    $_contents = ob_get_contents();
    ob_end_clean();
	
    if (!empty($params['assign'])) {
        $smarty->assign($params['assign'], $_contents);
    } else {
        return $_contents;
    }
}

/* vim: set expandtab: */

?>

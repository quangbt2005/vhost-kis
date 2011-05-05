<?php
    define("SMARTY_DIR", "/usr/local/lib/php/Smarty/");
    require_once(SMARTY_DIR . "Smarty.class.php");

    class SmartyEx extends Smarty
    {
        function SmartyEx()
        {
            $_DocRoot = $_SERVER['DOCUMENT_ROOT'];
            $this->Smarty();
            $this->template_dir = $_DocRoot . "/templates/";
            $this->compile_dir = $_DocRoot . "/templates/templates_c/";
        }
    }
?>
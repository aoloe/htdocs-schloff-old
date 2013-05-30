<?php
if (__FILE__ == $_SERVER['SCRIPT_FILENAME']) die('no access');

class Template {
    var $vars;

    /**
     * Constructor
     *
     * @param $file string the file name you want to load
     */
    function Template($file = null) {
        $this->file = $file;
    }

    /**
     * Set the template file
     */
    function set_template($file) {
        $this->file = $file;
    }

    /**
     * Clear the templates variables
     */
    function clear() {
        unset($this->vars);
    }

    /**
     * Set a template variable.
     */
    function set($name, $value) {
        $this->vars[$name] = $value;
    }

    /**
     * Open, parse, and return the template file.
     *
     * @param $_p_file string the template file name
     *  (name obfuscated to avoid clashes with template variables names)
     */
    function fetch($_p_file = null) {
        if(!$_p_file) {$_p_file = $this->file;}

        if (!empty($this->vars)) {
            extract($this->vars);      // Extract the vars to local namespace
        }
        ob_start();                    // Start output buffering
        if (class_exists('Filesystem')) {
            $file = Filesystem::get($file);
        }
        if (file_exists($_p_file)) {
            include($_p_file);                // Include the file
        } else {
            Debugger::show_backtrace();
            Debugger::show('could not find file', $file);
            Debugger::halt();
        }
        $contents = ob_get_contents(); // Get the contents of the buffer
        ob_end_clean();                // End buffering and discard
        return $contents;              // Return the contents
    }

    /**
     * Replace the the variables in $pattern with the values in $vars and in $this->vars and
     * return the result.
     *
     * @param   string  $pattern    the pattern with the variables to replace
     * @param   array   $vars       an array with the values to insert in the pattern
     * @return  string              the resulting string
     */
    function tr($pattern, $vars = array()) {
        $result = "";
        if (!empty($vars)) {
            extract($vars);            // Extract the vars to local namespace
        }
        if (!empty($this->vars)) {
            extract($this->vars);      // Extract the object's vars to local namespace
        }
        eval("\$result = \"$pattern\";");
        // echo("<pre>result\n".htmlentities(print_r($result, 1))."</pre>\n");
        return $result;                // Return the contents
    }
}

?>

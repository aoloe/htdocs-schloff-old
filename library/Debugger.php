<?php

if (__FILE__ == $_SERVER['SCRIPT_FILENAME']) die('no access');

/**
 * @log: 080803 copied to xox/wiki
 */
class Debugger {

    protected static $backtrace_active = false;
    protected static $backtrace = false;
    protected static $caller = array();
    protected static $log = array();

    
    public static function show_backtrace() {self::$backtrace_active = true;}

    protected static function read_backtrace() {
        $backtrace = array_reverse(debug_backtrace());
        $document_root_chars = strlen($_SERVER['DOCUMENT_ROOT']);
        // echo("<pre>document_root: ".realpath($_SERVER['DOCUMENT_ROOT'])."</pre>\n");
        $item_previous = array();
        self::$backtrace = array();
        self::$caller = array();
        foreach ($backtrace as $item) {
            // echo("<pre>item: ".print_r($item, 1)."</pre>\n");
            if ($item['file'] !== __FILE__) {
                if (isset($item['class']) && ($item['class'] == __CLASS__)) {
                    if (empty(self::$caller)) {
                        // self::$caller = $item;
                        self::$caller['line'] = $item['line'];
                        self::$caller['file'] = $item['file'];
                        self::$caller['file_local'] = substr($item['file'], $document_root_chars);
                        self::$caller['file_name'] = basename($item['file']);
                        self::$caller['class'] = $item_previous['class'];
                        self::$caller['type'] = $item_previous['type'];
                        self::$caller['function'] = $item_previous['function'];
                        self::$caller['string'] .= sprintf(
                            '<kbd>[%s] <span title="%s">%s</span> %s%s%s()</kbd>',
                            self::$caller['line'],
                            self::$caller['file_local'],
                            self::$caller['file_name'],
                            self::$caller['class'],
                            self::$caller['type'],
                            self::$caller['function']
                        );
                    }
                } else { // if in Debugger
                    $argument = array();
                    if (!empty($item['args'])) {
                        foreach ($item['args'] as $iitem) {
                            if (is_string($iitem)) {
                                $argument[] = "'".htmlspecialchars($iitem)."'";
                            } elseif (is_array($iitem)) {
                                $argument[] = htmlspecialchars('array('.implode(',', $iitem).')');
                            } elseif (is_object($iitem)) {
                                $argument[] = get_class($iitem);
                            }
                        }
                    }
                    if (empty($item['class'])) {
                        self::$backtrace[] = sprintf(
                            '[%s] %s %s(%s)',
                            $item['line'],
                            substr($item['file'], $document_root_chars),
                            $item['function'],
                            implode(',', $argument)
                        );
                    } else {
                        self::$backtrace[] = sprintf(
                            '[%s] %s %s%s%s(%s)',
                            $item['line'],
                            substr($item['file'], $document_root_chars),
                            $item['class'],
                            $item['type'],
                            $item['function'],
                            substr(implode(',', $argument), 0, 100)
                        );
                    }
                } // else in Debugger
                $item_previous = $item;
            } // if !__file__
        } // foreach backtrace
    } // Debugger::read_backtrace()

    static function show($label = null, $value = null) {
        self::read_backtrace();
        $result = '<p style="margin-bottom:0px; border:1px solid lightgray;">';
        $result .= self::$caller['string'].': ';
        if (isset($label)) {
            $result .= '<kbd>'.htmlentities($label).'</kbd>';
            if (isset($value)) {
                $result .= ': <kbd>'.htmlentities(print_r($value, 1)).'</kbd>'."\n";
            }
        } else {
            $result .= '<kbd>chuila</kbd>';
        }
        $result .= "</p>\n";
        
        if (self::$backtrace_active) {
            $result .= '<pre style="margin-top:0px; background-color:lightgray;">'.implode("\n", self::$backtrace).'</pre>'."\n";
            self::$backtrace_active = false;
        }
        echo($result);
    } // Debugger::show()

    static function structure($label, $value, $output = true) {
        $result = "";
        self::read_backtrace();
        $result = '<div style="margin-bottom:0px; border:1px solid lightgray;">';
        $result .= self::$caller['string']."<br /><kbd>".$label.":</kbd>\n";
        $result .= '<pre>'.htmlentities(print_r($value, 1)).'</pre></div>'."\n";
        if (self::$backtrace_active) {
            $result .= '<pre style="margin-top:0px; background-color:lightgray;">'.implode("\n", self::$backtrace).'</pre>'."\n";
            self::$backtrace_active = false;
        }

        // echo("<pre>".print_r($_SERVER, 1)."</pre>\n");
        // echo("<pre>".print_r($backtrace, 1)."</pre>\n");

        if ($output) {
            echo($result);
        } else {
            return $result;
        }

    }// Debugger::structure()

    public function halt($message = null) {
        if (!isset($message)) {
            $message = 'dying...';
        }
        self::show($message);
        die();
    } // Debugger::halt()

    public function log($label, $value) {
        self::read_backtrace();
        self::$log[] = array(
            'label' => $label,
            'value' => $value,
            'context' => "",
        );
    } // Debugger::log()

    /**
     * show the log's content
     * @todo: attach the log with js/dhtml to the top left corner (clickable)
     */
    public function flush() {
        $string = "<p><strong>log</strong></p>";
        if (!empty(self::$log)) {
            foreach (self::$log as $item) {
                #$string .= $item['label'].'='.$item['value'];
                $string .= self::structure($item['label'], $item['value'], false);
            }
            echo('<div style="border:1px solid darkgray; padding:2px;">'.$string.'</div>');
        }
    } // Debugger::flush()

} // Debugger
?>

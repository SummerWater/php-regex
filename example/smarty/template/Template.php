<?php
/**
 * Created by PhpStorm.
 * User: Meckey_Shu
 * Date: 2018/6/22
 * Time: 13:51
 */

class Template
{
    private $leftTag = '{#';
    private $rightTag = '#}';
    private $ext = '.html';
    private $sourceDir;
    private $compiledDir;
    private $varPool = [];
    private $outputHtml;
    private $currentTemp;

    public function __construct($sourceDir, $compiledDir)
    {
        $this->sourceDir = $sourceDir;
        $this->compiledDir = $compiledDir;
    }

    public function assign($tag, $val)
    {
        $this->varPool[$tag] = $val;
    }

    public function getVal($tag)
    {
        return $this->varPool[$tag];
    }

    public function getSourceTemplate($templateName)
    {
        $this->currentTemp = $templateName;
        $templateName = $this->sourceDir . $templateName . $this->ext;
        $this->outputHtml = file_get_contents($templateName);
    }

    public function compileTemplate($templateName = null)
    {
        $templateName = empty($templateName) ? $this->currentTemp : $templateName;
        $pattern = '/' . preg_quote($this->leftTag);
        $pattern .= '\$([a-zA-z_]\w*)';
        $pattern .= preg_quote($this->rightTag) .'/';
        $replaccement = '<?php echo $this->getVal(\'$1\');?>';
        $this->outputHtml = preg_replace($pattern, $replaccement, $this->outputHtml);
        $compiledFilename = $this->compiledDir . md5($templateName) . $this->ext;
        file_put_contents($compiledFilename, $this->outputHtml);
    }

    public function display($templateName = null)
    {
        $templateName = empty($templateName) ? $this->currentTemp : $templateName;
        $compiledName = $this->compiledDir . md5($templateName) . $this->ext;
        $sourceName = $this->sourceDir . $templateName . $this->ext;
        // 判断编译后的文件是否存在
        if (!is_file($compiledName)) {
            $this->getSourceTemplate($templateName);
            $this->compileTemplate();
        } else if (filemtime($sourceName) - filemtime($compiledName) > 0) {
            // 判断模板文件是否修改
            $this->getSourceTemplate($templateName);
            $this->compileTemplate();
        }
        include_once $compiledName;
    }
}
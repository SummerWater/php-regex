<?php
/**
 * Created by PhpStorm.
 * User: Meckey_Shu
 * Date: 2018/6/22
 * Time: 10:40
 */
class Regextool
{
    // 常见的正则表达式
    private $validate = [
        'require'   =>  '/.+/',
        'email'     =>  '/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/',
        'url'       =>  '/^http(s?):\/\/(?:[A-za-z0-9-]+\.)+[A-za-z]{2,4}(?:[\/\?#][\/=\?%\-&~`@[\]\':+!\.#\w]*)?$/',
        'currency'  =>  '/^\d+(\.\d+)?$/',
        'number'    =>  '/^\d+$/',
        'zip'       =>  '/^\d{6}$/',
        'integer'   =>  '/^[-\+]?\d+$/',
        'double'    =>  '/^[-\+]?\d+(\.\d+)?$/',
        'english'   =>  '/^[A-Za-z]+$/',
        'qq'		=>	'/^\d{5,11}$/',
        'mobile'	=>	'/^1(3|4|5|7|8)\d{9}$/',
    ];

    private $returnMatchResult = false; // 输出格式
    private $isMatch = false; // 默认为匹配失败 returnMatchResult === false 时返回
    private $matches = []; // 匹配到的数据 returnMatchResult === true 时返回
    private $fixMode = null; // 修正模式

    // 接受返回类型和修正模式
    public function __construct($returnMatchResult = false, $fixMode = null)
    {
        $this->returnMatchResult = $returnMatchResult;
        $this->fixMode = $fixMode;
    }

    /**
     * 正则匹配
     * @param $pattern
     * @param $subject
     * @return array|bool
     */
    private function regex($pattern, $subject)
    {
        if (array_key_exists(strtolower($pattern), $this->validate)) {
            $pattern = $this->validate[$pattern] . $this->fixMode;
        }
        $this->returnMatchResult ?
            preg_match_all($pattern, $subject,$this->matches) :
            $this->isMatch = preg_match($pattern, $subject) === 1;
        return $this->getRegexResult();
    }

    /**
     * 根据returnMatchResult返回相应的结果
     * @return array|bool
     */
    private function getRegexResult()
    {
        if ($this->returnMatchResult) {
            return $this->matches;
        }
        return $this->isMatch;
    }

    /**
     * 切换returnMatchResult
     * @param null $bool
     */
    public function toggleRetuenType($bool = null)
    {
        if ($bool === null) {
            $this->returnMatchResult = !$this->returnMatchResult;
        } else {
            $this->returnMatchResult = is_bool($bool) ? $bool : (bool)$bool;
        }
    }

    /**
     * 切换修正模式
     * @param $fixMode
     */
    public function setFixMode($fixMode)
    {
        $this->fixMode = $fixMode;
    }

    /**
     * 判断非空
     * @param $str
     * @return array|bool
     */
    public function noEmpty($str)
    {
        return $this->regex('require', $str);
    }

    /**
     * 验证Email
     * @param $email
     * @return array|bool
     */
    public function isEmail($email)
    {
        return $this->regex('email', $email);
    }

    /**
     * 验证手机号
     * @param $mobile
     * @return array|bool
     */
    public function isMobile($mobile)
    {
        return $this->regex('mobile', $mobile);
    }

    /**
     * 自定义正则表达式
     * @param $pattern
     * @param $subject
     * @return array|bool
     */
    public function check($pattern, $subject)
    {
        return $this->regex($pattern, $subject);
    }
}
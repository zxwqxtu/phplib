<?php
/**
 * XML处理
 * 采用SimpleXMLElement
 * 对维数组直接转换成xml格式
 *
 * @author by wangqiang <wangqiang@e.hunantv.com>
 */
namespace Xml;

/**
 * XML处理
 * 采用SimpleXMLElement
 */
class SimpleXml
{
    private $_xml = null;

    /**
     * 构造函数
     *
     * @param string $encoding utf-8
     */
    public function __construct($encoding="UTF-8")
    {
        $xmlStr = "<?xml version=\"1.0\" encoding=\"{$encoding}\" ?>";
        $this->_xml = new \SimpleXMLElement($xmlStr);
    }

    /**
     * 数组转换成xml
     * 支持多维数组
     *
     * @param array             $arr           数组
     * @param \SimpleXMLElement $xmlObj        对象
     * @param string            $numericPrefix 对数组数字键的处理
     *
     * @return \Xml\SimpleXml
     */
    public function arrayToXml($arr, $xmlObj=null, $numericPrefix='item')
    {
        if (is_null($xmlObj)) {
            $xmlObj = $this->_xml;
        }
        foreach ($arr as $k=>$v) {
            if (is_numeric($k)) {
                $k = $numericPrefix;
            }
            if (is_array($v)) {
                $newXml = $xmlObj->addChild($k);
                $this->arrayToXml($v, $newXml);
            } else {
                $xmlObj->addChild($k, htmlspecialchars($v));
            }
        }
        $this->_xml = $xmlObj;

        return $this; 
    }

    /**
     * 获取xml
     *
     * @return \SimpleXMLElement
     */
    public function getXml()
    {
        return $this->_xml;
    }

    /**
     * 返回字符串
     *
     * @return string
     */
    public function getXmlStr()
    {
        return $this->_xml->asXML();
    }

    /**
     * 生成文件
     *
     * @param string $fileName 文件名
     *
     * @return boolean 
     */
    public function file($fileName)
    {
        return $xml->saveXML($fileName);
    }
}
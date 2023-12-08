<?php

namespace App\Service\WechatBot\Friend;
interface FriendInterface
{

    /**
     *微信id
     * @return string
     */
    public function getUserName():string;

    /**
     *昵称
     * @return string
     */
    public function getNickName():string;

    /**
     *备注
     * @return string
     */
    public function getRemark():string;

    /**
     *签名
     * @return string
     */
    public function getSignature():string;

    /**
     *性别
     * @return int
     */
    public function getSex():int;

    /**
     *微信号
     * @return string
     */
    public function getAliasName():string;

    /**
     *国家
     * @return string
     */
    public function getCountry():string;

    /**
     *大头像
     * @return string
     */
    public function getBigHead():string;

    /**
     *小头像
     * @return string
     */
    public function getSmallHead():string;

    /**
     *标签列表
     * @return array
     */
    public function getLabelList():array;

    /**
     * 用户的wxId
     * @return string
     */
    public function getWechatId():string;

}
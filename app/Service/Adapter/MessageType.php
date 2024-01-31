<?php

namespace App\Service\Adapter;

enum MessageType: string
{
    //元事件
    case  META_TEST_CALLBACK_ADDRESS = '00000';

    // 通知消息类型
    case  NOTICE_OFFLINE = '30000';
    case  NOTICE_FRIEND_ADD = '30001';
    case  NOTICE_DOWNLOAD_MESSAGE_VIDEO_COMPLETION = '30002';

    case  NOTICE_FILE_SENT_SUCCESS = '60009';

    // 私聊消息类型定义
    case  PRIVATE_TEXT = '60001';
    case  PRIVATE_IMAGE = '60002';
    case  PRIVATE_VIDEO = '60003';
    case  PRIVATE_VOICE = '60004';
    case  PRIVATE_CARD = '60005';
    case  PRIVATE_EMOJI = '60006';
    case  PRIVATE_LINK = '60007';
    case  PRIVATE_FILE = '60008';

    case  PRIVATE_MINI_PROGRAM = '60010';
    case  PRIVATE_CHAT_HISTORY = '60011';
    case  PRIVATE_VOICE_CHAT = '60012';
    case  PRIVATE_VOICE_CHAT_HANGUP = '60013';
    case  PRIVATE_QUOTE_MESSAGE = '60014';
    case  PRIVATE_TRANSFER = '60015';
    case  PRIVATE_RED_PACKET = '60016';
    case  PRIVATE_VIDEO_NUMBER = '60017';
    case  PRIVATE_REVOKE_MESSAGE = '60018';
    case  PRIVATE_PAT = '60019';
    case  PRIVATE_LOCATION = '60020';
    case  PRIVATE_MUSIC_SHARE = '60021';
    case  PRIVATE_GROUP_INVITE_LINK = '60022';
    case  PRIVATE_OTHERS = '60999';

    // 群聊消息类型定义
    case  GROUP_TEXT = '80001';
    case  GROUP_IMAGE = '80002';
    case  GROUP_VIDEO = '80003';
    case  GROUP_VOICE = '80004';
    case  GROUP_CARD = '80005';
    case  GROUP_EMOJI = '80006';
    case  GROUP_LINK = '80007';
    case  GROUP_FILE = '80008';
    case  GROUP_FILE_SENT = '80009';
    case  GROUP_MINI_PROGRAM = '80010';
    case  GROUP_CHAT_HISTORY = '80011';
    case  GROUP_VOICE_CHAT = '80012';
    case  GROUP_QUOTE_MESSAGE = '80014';
    case  GROUP_TRANSFER = '80015';
    case  GROUP_RED_PACKET = '80016';
    case  GROUP_VIDEO_NUMBER = '80017';
    case  GROUP_REVOKE_MESSAGE = '80018';
    case  GROUP_PAT = '80019';
    case  GROUP_LOCATION = '80020';
    case  GROUP_MUSIC_SHARE = '80021';
    case  GROUP_NOTICE_CHANGE = '85001';
    case  GROUP_MEMBER_REMOVED = '85002';
    case  GROUP_MEMBER_KICKED = '85003';
    case  GROUP_DISBANDED = '85004';
    case  GROUP_NAME_CHANGED = '85005';
    case  GROUP_ADMIN_ADDED = '85006';
    case  GROUP_ADMIN_REMOVED = '85007';
    case  GROUP_MEMBER_INVITED = '85008';
    case  GROUP_MEMBER_JOINED_VIA_QR = '85009';
    case  GROUP_OWNER_CHANGED = '85010';
    case  GROUP_ANNOUNCEMENT = '85011';
    case  GROUP_TO_DO = '85012';
    case  GROUP_INVITE_CONFIRMATION = '85013';
    case  GROUP_INVITE_CONFIRMATION_NOTICE = '85014';
    case  GROUP_MEMBER_EXIT = '85015';
    case  GROUP_OTHERS = '80999';

    public static function metaTypes(): array
    {
        return [self::META_TEST_CALLBACK_ADDRESS];
    }

    public static function noticeTypes(): array
    {
        return [self::NOTICE_OFFLINE, self::NOTICE_FRIEND_ADD, self::NOTICE_DOWNLOAD_MESSAGE_VIDEO_COMPLETION];
    }

    public static function privateMessageTypes(): array
    {
        return [self::PRIVATE_TEXT, self::PRIVATE_IMAGE /* ...其他私聊消息类型 */];
    }

    public static function groupMessageTypes(): array
    {
        return [self::GROUP_TEXT, self::GROUP_IMAGE /* ...其他群聊消息类型 */];
    }


}
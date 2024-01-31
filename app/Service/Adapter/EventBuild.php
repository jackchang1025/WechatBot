<?php

namespace App\Service\Adapter;

use App\Service\OneBot\Event\Message\GroupMessageEvent;
use App\Service\OneBot\Event\Message\MessageEvent;
use App\Service\OneBot\Event\Message\PrivateMessageEvent;
use App\Service\OneBot\Event\Meta\ConnectEvent;
use App\Service\OneBot\Event\Meta\HeartbeatEvent;
use App\Service\OneBot\Event\Meta\MetaEvent;
use App\Service\OneBot\Event\Meta\StatusUpdateEvent;
use App\Service\OneBot\Event\Notice\Group\GroupNoticeEvent;
use App\Service\OneBot\Event\Notice\NoticeEvent;
use App\Service\OneBot\Event\Notice\Private\PrivateNoticeEvent;
use App\Service\OneBot\Event\OneBotEvent;
use App\Service\OneBot\Event\SelfInfo;
use App\Service\OneBot\Message\Message;
use App\Service\OneBot\Message\MessageSegment;

class EventBuild
{
    /**
     * @var string 事件唯一标识符
     */
    public string $id;
    /**
     * @var float 事件发生时间（Unix 时间戳），单位：秒，建议优先采用聊天平台给出的时间，其次采用实现中创建事件对象的时间
     */
    public float $time;
    /**
     * @var string 事件类型，必须是 meta、message、notice、request 中的一个，分别表示元事件、消息事件、通知事件和请求事件
     */
    public string $type;

    /**
     * @var string 事件详细类型
     */
    public string $detailType;
    /**
     * @var string 事件子类型（详细类型的下一级类型）
     */
    public string $subType;
    /**
     * @var SelfInfo  用于唯一标识一个机器人账号，应包含以下字段：
     */
    public SelfInfo $self;
    /**
     * @var string 消息 ID，用于消息去重
     */
    public string $messageId;
    /**
     *
     * @var Message 消息
     */
    public Message $message;
    /**
     * @var string 作为消息的纯文本替代表示
     */
    public string $altMessage;
    /**
     * @var string
     */
    public string $userId;
    /**
     * 消息内容
     * @var string
     */
    protected string $content;
    /**
     * @var string 群组 ID
     */
    protected string $groupId;

    /**
     * @var string 操作者 ID
     */
    protected string $operatorId;

    /**
     * 心跳间隔，单位：毫秒，必须大于 0
     * @var int
     */
    protected int $interval = 1000;

    /**
     * @var array OneBot 实现端状态信息，与 get_status 动作响应数据一致
     */
    protected array $state = [];

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getTime(): float
    {
        return $this->time;
    }

    public function setTime(float $time): static
    {
        $this->time = $time;

        return $this;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getDetailType(): string
    {
        return $this->detailType;
    }

    public function setDetailType(string $detailType): static
    {
        $this->detailType = $detailType;

        return $this;
    }

    public function getInterval(): int
    {
        return $this->interval;
    }

    public function setInterval(int $interval): static
    {
        $this->interval = $interval;

        return $this;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function build(): OneBotEvent
    {
        try {
            return match ($this->type) {
                'meta' => $this->buildMetaEvent(),
                'message' => $this->buildMessageEvent(),
                'notice' => $this->buildNoticeEvent(),
                default => throw new \InvalidArgumentException("Unsupported event type: {$this->type}"),
            };
        } catch (\Exception $e) {
            // 处理构建事件过程中的任何异常
            // 可以记录日志、返回错误信息等
            throw new \RuntimeException("Failed to build event: ".$e->getMessage(), 0, $e);
        }
    }

    protected function buildMetaEvent(): MetaEvent
    {
        return match ($this->subType) {
            'connect' => new ConnectEvent($this->id, $this->time, $this->subType, []),
            'heartbeat' => new HeartbeatEvent($this->id, $this->time, $this->subType, $this->interval),
            'status_update' => new StatusUpdateEvent($this->id, $this->time, $this->subType, $this->getState()),
            default => throw new \Exception('Unsupported subtype: '.$this->subType),
        };
    }

    public function getState(): array
    {
        return $this->state;
    }

    public function setState(array $state): static
    {
        $this->state = $state;

        return $this;
    }

    protected function buildMessageEvent(): MessageEvent
    {
        return match ($this->getDetailType()) {

            'private' => new PrivateMessageEvent(
                $this->id,
                $this->time,
                $this->subType,
                $this->getSelf(),
                $this->getMessageId(),
                $this->getMessage(),
                $this->getAltMessage(),
                $this->getUserId()
            ),

            'group' => new GroupMessageEvent(
                $this->id, $this->time, $this->subType, $this->getSelf(), $this->getMessageId(), $this->getMessage()
                , $this->getAltMessage(), $this->getUserId(), $this->getGroupId()
            ),

            default => throw new \Exception('Unsupported subtype: '.$this->subType),
        };
    }

    public function getSelf(): SelfInfo
    {
        return $this->self;
    }

    public function setSelf(SelfInfo $self): static
    {
        $this->self = $self;

        return $this;
    }

    public function getMessageId(): string
    {
        return $this->messageId;
    }

    public function setMessageId(string $messageId): static
    {
        $this->messageId = $messageId;

        return $this;
    }

    public function getMessage(): Message
    {
        return $this->message;
    }

    public function setMessage(Message $message): static
    {
        $this->message = $message;

        return $this;
    }

    public function getAltMessage(): string
    {
        return $this->altMessage;
    }

    public function setAltMessage(string $altMessage): static
    {
        $this->altMessage = $altMessage;

        return $this;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function setUserId(string $userId): static
    {
        $this->userId = $userId;

        return $this;
    }

    public function getGroupId(): string
    {
        return $this->groupId;
    }

    public function setGroupId(string $groupId): static
    {
        $this->groupId = $groupId;

        return $this;
    }

    protected function buildNoticeEvent(): NoticeEvent
    {
        return match ($this->subType) {
            'private' => new PrivateNoticeEvent(
                id: $this->id,
                time: $this->time,
                self: $this->getSelf(),
                userId: $this->getUserId(),
                subType: $this->getSubType()
            ),

            'group' => new GroupNoticeEvent(
                id: $this->id,
                time: $this->time,
                self: $this->getSelf(),
                subType: $this->subType,
                groupId: $this->getGroupId(),
                messageId: $this->getMessageId(),
                userId: $this->getUserId(),
                operatorId: $this->getOperatorId(),
            ),
        };
    }

    public function getSubType(): string
    {
        return $this->subType;
    }

    public function setSubType(string $subType): static
    {
        $this->subType = $subType;

        return $this;
    }

    public function getOperatorId(): string
    {
        return $this->operatorId;
    }

    public function setOperatorId(string $operatorId): static
    {
        $this->operatorId = $operatorId;

        return $this;
    }


}
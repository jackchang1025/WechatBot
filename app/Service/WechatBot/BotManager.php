<?php

namespace App\Service\WechatBot;

use App\Service\WechatBot\User\User;
use App\Service\WechatBot\User\UserManager;
use Exception;
use Hyperf\Collection\Collection;
use Hyperf\Contract\ContainerInterface;
use Hyperf\Redis\Redis;

/**
 * @Singleton
 */
class BotManager
{
    /**
     * @var Collection
     * 存储所有的 WechatBot 实例
     */
    protected Collection $bots;

    public function __construct(protected Redis $redis)
    {
    }

    public function add($name, $data){
        return $this->redis->hSet('wechat_bots', $name, $data);
    }

    public function hGetAll(){
        return $this->redis->hGetAll('wechat_bots');
    }

    // 获取所有的 WechatBot 实例
    public function getBots(): array
    {
        $allBots = $this->redis->hGetAll('wechat_bots');
        return array_map([$this, 'deserializeBot'], $allBots);
    }

    public static function buildBot(ServiceProviderInterface $serviceProvider): WechatBot
    {
        $user = new User([], $serviceProvider);

        new UserManager($user, $serviceProvider);

        return new WechatBot(new UserManager($user, $serviceProvider), $serviceProvider);
    }

    /**
     * 创建一个新的 WechatBot 实例
     *
     * @param string $wcId 微信ID
     * @param WechatBot $wechatBot
     * @return WechatBot
     * @throws Exception
     */
    public function createBot(string $wcId, WechatBot $wechatBot): WechatBot
    {
        if ($this->redis->hExists('wechat_bots', $wcId)) {
            throw new Exception('WechatBot 实例已存在');
        }

        $this->redis->hSet('wechat_bots', $wcId, $this->serializeBot($wechatBot));
        return $wechatBot;
    }

    // 通过微信ID查找 WechatBot 实例
    public function findBotByWcId(string $wcId): ?WechatBot
    {
        $botData = $this->redis->hGet('wechat_bots', $wcId);
        return $botData ? $this->deserializeBot($botData) : null;
    }

    // 删除指定的 WechatBot 实例
    public function deleteBot(string $wcId): void
    {
        $this->redis->hDel('wechat_bots', $wcId);
    }

    // 将 WechatBot 实例序列化为字符串
    private function serializeBot(WechatBot $bot): string
    {
        return serialize($bot);
    }

    // 将字符串反序列化为 WechatBot 实例
    private function deserializeBot(string $botData): WechatBot
    {
        return unserialize($botData);
    }
}

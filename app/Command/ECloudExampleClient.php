<?php

declare(strict_types=1);

namespace App\Command;

use App\Service\ECloud\Enum\MessageType;
use App\Service\ECloud\ExampleServiceProviderAProvider;
use App\Service\ECloud\Login\LoginHandle;
use App\Service\ECloud\MessageFormat\TextMessage;
use App\Service\WechatBot\Middleware\MessageMiddleware;
use App\Service\WechatBot\Middleware\Middleware;
use App\Service\WechatBot\Server;
use App\Service\WechatBot\WechatBot;
use Faker\Factory;
use Faker\Generator;
use Hyperf\Command\Command as HyperfCommand;
use Hyperf\Command\Annotation\Command;
use Hyperf\Contract\ConfigInterface;
use Psr\Container\ContainerInterface;
use Swoole\Coroutine\Http\Client;

#[Command]
class ECloudExampleClient extends HyperfCommand
{
    protected Generator $faker;

    public function __construct(
        protected ContainerInterface $container,
        protected LoginHandle $loginHandle,
        protected ConfigInterface $config
    ) {
        parent::__construct('ecloud:client');

        $this->faker = Factory::create('zh_CN');
    }

    public function configure()
    {
        parent::configure();
        $this->setDescription('Hyperf Demo Command');
    }

    public function handle()
    {

        echo "准备启动 Swoole HTTP 客户端 {$this->config->get('wechat.http_callback_host')}:{$this->config->get('wechat.http_callback_port')} \n";

        $client = new Client(
            $this->config->get('wechat.http_callback_host'),
            $this->config->get('wechat.http_callback_port')
        );

        $client->setHeaders([
            'Host'            => 'localhost',
            'User-Agent'      => 'Chrome/49.0.2587.3',
            'Accept'          => 'text/html,application/xhtml+xml,application/xml',
            'Accept-Encoding' => 'gzip',
        ]);

        //参数名	类型	说明
        //wcId	String	微信id
        //account	String	账号
        //messageType	String	消息类型
        //data	JSONObject	消息体
        //data.fromUser	String	发送微信id
        //data.fromGroup	String	发送群号
        //data.toUser	String	接收微信id
        //data.msgId	long	消息msgId
        //data.newMsgId	long	消息newMsgId
        //data.timestamp	long	时间
        //data.content	String(文本消息) 或 XML（图片、视频消息）	消息体
        //data.self	boolean	是否是自己发送的消息

        while (true) {

            sleep(rand(5, 10));

            $type = $this->faker->randomElement(MessageType::getValues());

            var_dump($type);
            $data = match ($type) {
                MessageType::Text->value => $this->buildTextMessage(),
                MessageType::Image->value => $this->buildImageMessage(),
                default => throw new \Exception('暂不支持该消息类型'),
            };

            $client->post($this->config->get('wechat.http_callback_url'), $data);
        }
    }

    public function buildTextMessage(): array
    {
        return [
            "wcId"        => "wxid_phyyedw9xap22",
            'account'     => $this->faker->name,
            'messageType' => MessageType::Text->value,
            'data'        => [
                "content"   => $this->faker->text,
                "fromUser"  => $this->faker->uuid,
                "msgId"     => $this->faker->randomNumber(6),
                "newMsgId"  => $this->faker->randomNumber(6),
                "self"      => false,
                "timestamp" => $this->faker->unixTime(),
                "toUser"    => "wxid_phyyedw9xap22",
                "wId"       => "12491ae9-62aa-4f7a-83e6-9db4e9f28e3c",
            ],
        ];
    }

    public function buildImageMessage(): array
    {
        return [
            "wcId"        => "wxid_phyyedw9xap22",
            'account'     => $this->faker->name,
            'messageType' => MessageType::Image->value,
            'data'        => [
                "content"   => '<?xml version=\"1.0\"?>\n<msg>\n\t<img aeskey=\"d27706ca173c0bf53223b342a99803ed\" encryver=\"1\" cdnthumbaeskey=\"d27706ca173c0bf53223b342a99803ed\" cdnthumburl=\"304d0201000446304402010002043904752002033d11fd0204ba6f66b4020461cc3c83041f777869645f7068797965647739786170323231305f313634303737343738370204011400020201000400\" cdnthumblength=\"3594\" cdnthumbheight=\"96\" cdnthumbwidth=\"120\" cdnmidheight=\"0\" cdnmidwidth=\"0\" cdnhdheight=\"0\" cdnhdwidth=\"0\" cdnmidimgurl=\"304d0201000446304402010002043904752002033d11fd0204ba6f66b4020461cc3c83041f777869645f7068797965647739786170323231305f313634303737343738370204011400020201000400\" length=\"6504\" md5=\"629663f8419f6ce79d1dd1506b20f261\" />\n</msg>\n',
                "fromUser"  => $this->faker->uuid,
                "msgId"     => $this->faker->randomNumber(6),
                "newMsgId"  => $this->faker->randomNumber(6),
                "img"      => $this->faker->image(),
                "self"      => false,
                "timestamp" => $this->faker->unixTime(),
                "toUser"    => "wxid_phyyedw9xap22",
                "wId"       => "12491ae9-62aa-4f7a-83e6-9db4e9f28e3c",
            ],
        ];
    }
}

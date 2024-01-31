Bot 聊天机器人是一个基于 oneBot12 协议 的 hyperf 组件

## 需求分析和系统设计

架构设计：设计系统的高层架构，确定如何将系统分解为模块和子系统。

1. Bot 组件
    - 实现机器人的基本功能，如接收和发送消息。
    - 处理用户账户相关的逻辑，例如登录和认证。
2. BotManager 组件
    - 管理多个机器人实例。
    - 监测和维护机器人实例的连接状态。
    - 可以实现负载均衡和故障转移机制。
3. OneBot12 组件
    - 实现 OneBot 12 协议的具体逻辑。
    - 负责解析和构建遵循 OneBot 12 标准的消息格式。
4. Drive 组件

    - 负责适配和转换不同远程服务的消息格式。
    - 为 Bot 组件提供统一的接口来处理消息。

### 组件间的交互方式

#### BotManager 与 Bot 的交互：

管理与监控：BotManager 监控各个 Bot 实例的状态，比如在线状态、活跃度等。 d
任务分配：BotManager 根据需求向特定的 Bot 实例分配任务或转发请求。

#### Bot 与 OneBot12 的交互：

消息处理：Bot 通过 OneBot12 组件发送和接收遵循 OneBot 12 协议的消息。
事件订阅：Bot 订阅由
OneBot12 组件处理的事件，如接收消息、用户状态变更等。OneBot12 组件作为事件的分发者，将相关事件通知给相应的 Bot 实例。

#### OneBot12 与外部服务的交互：

协议转换：OneBot12 组件负责将外部服务的消息格式和协议转换为内部可识别的格式，反之亦然。
数据传输：OneBot12 组件作为一个中间层，处理与外部服务（例如不同的聊天平台）之间的数据传输。
BotManager 与 OneBot12 的间接交互：

虽然 BotManager 和 OneBot12 组件可能不直接交互，但 BotManager 通过管理 Bot 实例间接影响 OneBot12 组件的工作。例如，BotManager
可以决定启动新的 Bot 实例，这些实例将使用 OneBot12 组件与外部服务通信。
通过这种方式，各组件之间的交互保持了清晰和解耦，同时

## 功能规划

* 消息处理：支持文本、图片、视频、语音等消息类型的接收和发送。
* 好友和群管理：自动添加好友、群组管理、群消息处理。
* 朋友圈操作：发布、评论和点赞朋友圈。
* 视频账号操作：管理视频内容和互动。
* 标签和收藏管理：用户标签管理和内容收藏功能。
* 账户管理：登录、认证和安全设置。
* 特殊权限接口：处理需要高级权限的操作

* 技术实现
  核心功能开发
  模块化设计：确保代码易于维护和扩展。
  命名空间和自动加载：遵循 PSR-4 标准。
  面向接口编程：提高代码的灵活性和可测试性。
  配置管理：集中管理所有配置文件。
  依赖管理：使用 Composer 管理项目依赖。
  错误处理：健壮的错误和异常处理机制。

## 工作流程

### 发送消息

client 向 BotA(机器人) 或 BotB 发送消息到微信等平台流程：
首先 client 构建 Message 消息内容(OneBot12标准协议)，
构建发送 Fround 好友或者 group 群组，
构建 action(OneBot12协议) 例如：发送消息(send_message)，
client 获取 BotA(机器人) 或 BotB
Bot 机器人通过绑定的 RemoteServiceClientDrive(远程驱动)将 Message消息内容(OneBot12标准协议)转换为 RemoteService(
远程服务)消息格式，
然后通过远程服务通信协议 Http,websocket 等协议发送给远程服务

### 消息接收

RemoteServiceA(远程服务) 收到 wechat 服务消息将会转发给设置消息接收地址例如：127.0.0.1:9501/drive/RemoteServiceA
RemoteServiceB(远程服务) 收到 wechat 服务消息将会转发给设置消息接收地址例如：127.0.0.1:9501/drive/RemoteServiceB

机器人将监听消息接收地址并根据不同的路由调用不同的中间件处理消息，例如，127.0.0.1:9501/drive/RemoteServiceA 将调用
RemoteServiceA 中间件处理消息，RemoteServiceA 将调用RemoteServiceClientDrive(远程驱动) 将 RemoteService(远程服务)消息格式转换为
OneBot12 消息格式，然后通过 OneBot12 组件发送给 client。
client 处理后的消息通过 client 向 BotA(机器人) 或 BotB 发送消息到微信等平台流程发送回外部服务

> 每个Bot(机器人) 需要绑定 RemoteServiceClientDrive(远程驱动) 实现消息的转换和发送

我们还需要在消息接收工作流程根据不同的消息类型处理消息，例如：

1. 处理敏感词，
2. 下载图片，处理视频，处理文本消息，处理群消息，处理好友消息
3. 判断消息是发送给那个 bot 机器人
4. 服务器的token 校验
5. 根据 onebot12 协议处理消息 message消息 notice 消息 mate 元数据消息 request 消息等

## 错误处理和异常管理

在系统设计中，错误处理和异常管理是不可或缺的部分，确保系统的稳定性和可靠性。以下是处理不同类型错误或异常情况的方法：

1. 网络中断 重试机制：在网络请求中实现重试逻辑，如指数退避策略，以应对暂时的网络故障。
2. 状态检查：BotManager 定期检查 Bot 实例的连接状态，若检测到断开，尝试重新连接。
3. 协议不匹配 数据验证：OneBot12 组件在处理消息时进行数据格式和协议的验证，确保符合预期。
4. 异常捕获：在数据转换过程中捕获任何异常，并记录日志供后续分析。
5. 认证失败 错误响应：在认证失败时，系统应给出明确的错误响应，并阻止进一步的数据处理。
6. 统一异常处理 中央异常处理器：设计一个中央异常处理器，用于捕获和处理所有组件中的异常。
7. 分类处理：根据异常类型（如网络错误、数据错误、权限错误等）进行分类处理。 恢复策略：实现恢复策略，如回退操作、清理资源、重新初始化等。
   用户通知和日志记录

## 示例代码：

### 构建 bot机器人向外部发送消息

```php

//从新账号构建机器人，就是这个账号没有登录过
$bot =  BotBuilder::build(new Account(),new Driver($config));

//从登录过账号构建机器人机器人
$bot =  BotBuilder::build(new Account(wechatId:'xxxxxx',botId:'xxxxxx'),new Driver($config));

//构建 oneBot12标准协议 action 动作
$action = new Action('Login',$params = [], $echo = null, $self = []);
$action = new LoginAction($params = [],$echo = null, $self = []);

//检查机器人状态是否登录等
if(!$bot->checkLogin()){
    //尝试登录
    $bot->action($action);
}

//构建 oneBot12标准协议 message 消息
//文本消息
$message = new Message(MessageSegment::text('hello bot'));

//向好友发送消息
$friend = new Friend('xxxxxx');
$action = new SendMessageAction($message,$friend);
$bot->action($action);

//向群发送消息
$group = new Group('xxxxxx');
$action = new SendMessageAction($message,$group);
$bot->action($action);

//从容器获取BotManager
$botManager = $container->get(BotManager::class);

//将构建的机器人加入到BotManager 管理多个机器人实例
//监测和维护机器人实例的连接状态
$botManager->addBot($bot);
```

### 机器人接收外部服务消息

```php
//机器人消息接收地址 例如：127.0.0.1:9501/drive/DriveA
//机器人消息接收地址 例如：127.0.0.1:9501/drive/DriveB

//定义路由
//设置远程服务与驱动地址
Router::addGroup('/drive',function (){
    Router::addGroup('/DriveA',function (){
    //定义控制器
    Router::addRoute(['GET', 'POST', 'HEAD'], '/', 'OneBotEventController@index');
        //定义中间件进行数据格式验证和 OneBot12协议转换 敏感词检测
    },['middleware' => [RemoteServiceAMessageFormatMiddleware::class,SensitiveMiddleware::class]]);
    
    Router::addGroup('/DriveB',function (){
    //定义控制器
    Router::addRoute(['GET', 'POST', 'HEAD'], '/', 'OneBotEventController@index');
        //定义中间件进行数据格式验证和 OneBot12协议转换 敏感词检测
    },['middleware' => [RemoteServiceBMessageFormatMiddleware::class,SensitiveMiddleware::class]]);
});
```

在中间件中分发事件

```php
class RemoteServiceAMessageFormatMiddleware implements MiddlewareInterface{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        //数据格式验证
        MessageFormat::validate($request->getParsedBody());
        //OneBot12协议转换
        $event = MessageFormat::formatRemoteServiceOneBot($request->getParsedBody());
        //将事件保存到request中 供后续中间件和控制器使用
        $request->setAttribute('event',$event);
       
        //OneBot12 事件分发
        if ($this->container->has(EventDispatcherInterface::class)) {
            $EventDispatcherInterface = $this->container->get(EventDispatcherInterface::class);
            $EventDispatcherInterface->dispatch($event);
        }
        return $handler->handle($request);
    }
}
class SensitiveMiddleware implements MiddlewareInterface{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
       $event = $request->getAttribute('event',$event);
        //敏感词检测
        if (OneBotEvent::isSensitive($event->getMessage())) {
            return new Response();
        }
        return $handler->handle($request);
    }
}
//事件监听器
#[Listener]
class EventListener implements ListenerInterface
{
    public function __construct(protected ContainerInterface $container)
    {
    }

    public function listen(): array
    {
        return [
            OneBotEvent::class, // 监听私信事件
        ];
    }

    public function process(object $event): void
    {
        //获取机器人管理器 BotManager
        $botManager = $this->container->get(BotManager::class);
        //获取机器人实例Id
        $botId = $event->self()->user_id;
        //获取机器人实例平台
        $platform = $event->self()->platform;
        //获取机器人实例
        $bot = $botManager->get($platform,$botId);
        
        //处理事件
        if($event instanceof MessageEvent){
            //处理消息事件
        }
        if($event instanceof NoticeEvent){
            //处理通知事件
        }
        if($event instanceof MetaEvent){
            //处理元事件
        }

    }
}
```
在控制器中处理事件

```php

class OneBotEventController{
    public function index($request): ResponseInterface{
        $event = $request->getAttribute('event',$event);
        //获取机器人管理器 BotManager
        $botManager = $this->container->get(BotManager::class);
        //获取机器人实例Id
        $botId = $event->self()->user_id;
        //获取机器人实例平台
        $platform = $event->self()->platform;
        //获取机器人实例
        $bot = $botManager->get($platform,$botId);
        
        //处理事件
        if($event instanceof MessageEvent){
            //处理消息事件
        }
        if($event instanceof NoticeEvent){
            //处理通知事件
        }
        if($event instanceof MetaEvent){
            //处理元事件
        }
    }
}
```
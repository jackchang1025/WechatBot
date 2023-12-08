设计 WechatBot 的登录模块时可以依赖于一个LoginInterface实现，但是具体登录的实现应该是由具体的服务提供商来完成。
WechatBot类有一个ServiceProvider属性，它是 ServiceProviderInterface 的实现。 这个 ServiceProvider 类负责通过HTTP接口与第三方服务平台进行通信，实现机器人的操作，例如：登录，发送消息，接送消息

1. 在 WechatBot 的 User 类是保存用户信息的地方，它包含了用户的基本信息，如：昵称，头像，性别等，、
我们可以将 WechatBot 实例的 status 保存到 User 类中
2. 在 User 类中添加一个数据仓库接口，用于保存用户信息，用户消息，用户好友群组等，并实现了数据持久化和数据的修改和 WechatBot 实例的 status 更新，这个可以是 MySQL，Redis，MongoDB 等
3. 因为 WechatBot实例存储在 redis 中，WechatBot 的 User 类中添加 __sleep 和 __wakeup 魔术方法，用于数据仓库接口序列化和反序列化，这样每次从redis 中获取 WechatBot 实例时，都会从数据仓库中获取用户信息

请你验证上面的思路是否可行，否则给出更好的方案。最后尝试编写代码

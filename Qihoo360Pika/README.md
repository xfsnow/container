参考 Pika 在虚拟机安装的步骤

https://github.com/Qihoo360/pika/wiki/%E5%AE%89%E8%A3%85%E4%BD%BF%E7%94%A8

先从 https://github.com/Qihoo360/pika/releases 找到需要的编译好的版本，比如

https://github.com/Qihoo360/pika/releases/download/v3.3.6/pika-linux-x86_64-v3.3.6.tar.bz2

下载到本地，修改 Qihoo360Pika.Dockerfile 中压缩包文件名

```
#把压缩包复制到容器内
COPY pika-linux-x86_64-v3.0.13.tar.bz2 .
```
为下载的文件名。

然后运行以下命名构建镜像：
```
docker build -t yourname/pika -f Qihoo360Pika.Dockerfile .
```

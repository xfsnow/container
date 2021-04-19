参考 Pika 在虚拟机安装的步骤

https://github.com/Qihoo360/pika/wiki/%E5%AE%89%E8%A3%85%E4%BD%BF%E7%94%A8

先从 https://github.com/Qihoo360/pika/releases 找到需要的编译好的版本，比如

https://github.com/Qihoo360/pika/releases/download/v3.3.6/pika-linux-x86_64-v3.3.6.tar.bz2

下载到本地，解压这个压缩包，会得到一个 output 目录。

然后运行以下命名构建镜像：
```
docker build -t yourname/pika -f Qihoo360Pika.Dockerfile .
```

FROM centos

# 先全部更新一下
RUN yum -y update

# bzip2 安装上，才能解压tar.bz2的压缩包
RUN yum install -y bzip2

#指定工作目录为 /app
WORKDIR /app

#把压缩包复制到容器内
COPY pika-linux-x86_64-v3.0.13.tar.bz2 .

# 解压
RUN tar -jxvf pika-linux-x86_64-v3.0.13.tar.bz2

# 直接运行启动服务
ENTRYPOINT /app/output/bin/pika -c /app/output/conf/pika.conf

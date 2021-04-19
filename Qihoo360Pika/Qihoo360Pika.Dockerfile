FROM centos
# 先全部更新一下
RUN yum -y update

#指定工作目录为 /app
WORKDIR /app

#把解压后的内容复制到容器内
COPY output .

# 直接运行启动服务
ENTRYPOINT /app/bin/pika -c /app/conf/pika.conf

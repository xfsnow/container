FROM ubuntu:latest

# Configure for Ubuntu apt
RUN dpkg --configure -a && \
apt-get update -y && apt-get upgrade -y && apt-get install -y \
build-essential \
uuid-dev \
libgpgme-dev \
squashfs-tools \
libseccomp-dev \
wget \
pkg-config \
git \
cryptsetup-bin \
golang && \
export VERSION=3.9.9 && \
mkdir -p $HOME/sylabs && \
cd $HOME/sylabs && \
wget -t 0 -T 15 -c https://github.com/sylabs/singularity/releases/download/v${VERSION}/singularity-ce-${VERSION}.tar.gz && \
tar -xzf singularity-ce-${VERSION}.tar.gz && \
rm singularity-ce-${VERSION}.tar.gz  && \
cd ./singularity-ce-${VERSION} && \
./mconfig && \
make -C ./builddir && \
make -C ./builddir install

# Sleep so that the Pod in the DaemonSet does not exit
ENTRYPOINT ["tail", "-f", "/dev/null"]
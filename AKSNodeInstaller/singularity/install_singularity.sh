#!/bin/bash

# Configure for Ubuntu apt
dpkg --configure -a
# Update and install packages
apt-get update -y && apt-get upgrade -y && apt-get install -y \
build-essential \
uuid-dev \
libgpgme-dev \
squashfs-tools \
libseccomp-dev \
wget \
pkg-config \
git \
cryptsetup-bin

# Download and install Golang
export VERSION=1.18.2 OS=linux ARCH=amd64 && \
wget -t 0 -T 15 -c https://dl.google.com/go/go$VERSION.$OS-$ARCH.tar.gz \
sudo tar -C /usr/local -xzf go$VERSION.$OS-$ARCH.tar.gz && \
rm go$VERSION.$OS-$ARCH.tar.gz

echo 'export GOTOOLDIR="/usr/local/go/pkg/tool/linux_amd64"' >> ~/.bashrc && \
echo 'export GOROOT="/usr/local/go"' >> ~/.bashrc && \
echo 'export GOPATH="/home/go"' >> ~/.bashrc && \
echo 'export PATH=${PATH}:${GOROOT}/bin' >> ~/.bashrc && \
source ~/.bashrc

go version

# Download Singularity
export VERSION=3.9.9 && # adjust this as necessary \
mkdir -p $HOME/src/github.com/sylabs && \
cd $HOME/src/github.com/sylabs && \
wget -t 0 -T 15 -c https://github.com/sylabs/singularity/releases/download/v${VERSION}/singularity-ce-${VERSION}.tar.gz && \
tar -xzf singularity-ce-${VERSION}.tar.gz && \
rm singularity-ce-${VERSION}.tar.gz  && \
cd ./singularity-ce-${VERSION}

echo 'export SINGULARITYPATH=/opt/singularity' >> ~/.bashrc && \
echo 'export PATH=${PATH}:${SINGULARITYPATH}/bin' >> ~/.bashrc && \
source ~/.bashrc

# Compile and install Singularity
./mconfig --prefix=$SINGULARITYPATH && \
make -C ./builddir && \
make -C ./builddir install

# Sleep so that the Pod in the DaemonSet does not exit
sleep infinity
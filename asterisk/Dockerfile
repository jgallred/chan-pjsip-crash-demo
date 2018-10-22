FROM debian:stretch

RUN apt update \
    && apt-get install -y gdb build-essential wget libssl-dev libncurses5-dev libnewt-dev libxml2-dev \
    libsqlite3-dev uuid-dev git subversion

#RUN mkdir -p /usr/src/asterisk-src && cd /usr/src \
#    && wget https://downloads.asterisk.org/pub/telephony/asterisk/asterisk-15-current.tar.gz \
#    && tar zxvf asterisk-15-current.tar.gz -C asterisk-src --strip-components 1

RUN mkdir -p /usr/src/asterisk-src && cd /usr/src \
    && wget https://downloads.asterisk.org/pub/telephony/asterisk/asterisk-13-current.tar.gz \
    && tar zxvf asterisk-13-current.tar.gz -C asterisk-src --strip-components 1

# Have to install libssl1.0-dev after prereqs for asterisk 13 compatibility with debian 9
#    && ./configure \

RUN export DEBIAN_FRONTEND=noninteractive \
    && cd /usr/src/asterisk-src \
    && yes | contrib/scripts/install_prereq install \
    && apt install -y libssl1.0-dev \
    && ./configure --with-pjproject-bundled \
    && make menuselect.makeopts \
    && menuselect/menuselect --enable DONT_OPTIMIZE --enable BETTER_BACKTRACES menuselect.makeopts \
    && make \
    && make install \
    && make config \
    && make samples

COPY docker/asterisk/ /etc/asterisk/
COPY docker/entrypoint /usr/local/bin/entrypoint

ENTRYPOINT ["bash", "/usr/local/bin/entrypoint"]

CMD bash
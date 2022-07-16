FROM nginx:latest

ADD ./project-nginx.conf /etc/nginx/conf.d/default.conf
ADD ./ws-nginx.conf /etc/nginx/conf.d/ws-nginx.conf

RUN nproc
RUN lscpu
RUN ulimit -n

# RUN nginx -V
# RUN nginx -t

# RUN nginx -s reload
# RUN service nginx restart

WORKDIR /var/project

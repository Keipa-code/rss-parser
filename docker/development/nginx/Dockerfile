FROM nginx:1.19-alpine

RUN apk add --no-cache curl

COPY ./common/nginx/conf.d /etc/nginx/conf.d

WORKDIR /var/www
#!/bin/bash

# Verifica sudo
if command -V sudo > /dev/null 2>&1; then
    sudo_found="yes"
    sudo_cmd="sudo "
fi

# Verifica root
printf "$(tput setaf 6)> $(tput setaf 7)Verificando usuário administrador: "
if [ "`id -u`" = "0" ]; then
    sleep 2
    printf "$(tput setaf 6)ok$(tput setaf 7).\n"
    sudo_cmd=""
else
    if [ "$sudo_found" = "yes" ]; then
        sleep 2
        printf "$(tput setaf 3)você precisa de direitos sudo.\033[0m\n"
        exit 1
    else
        sleep 2
        printf "$(tput setaf 9)sem root, sudo não encontrado, saindo.\033[0m\n"
        exit 1
    fi
fi

# Instala repositorios necessarios
${sudo_cmd}apt install sed

codename="$(cat /etc/lsb-release |grep CODENAME |awk -F = {'print $2'})"
core=$(printf '%-1s' "$(grep -c cpu[0-9] /proc/stat)")

# Instalar última versão nginx
${sudo_cmd}echo "deb [arch=amd64] http://nginx.org/packages/mainline/ubuntu/ ${codename} nginx" > /etc/apt/sources.list.d/nginx.list
${sudo_cmd}echo "deb-src http://nginx.org/packages/mainline/ubuntu/ ${codename} nginx" >> /etc/apt/sources.list.d/nginx.list
${sudo_cmd}wget http://nginx.org/keys/nginx_signing.key
${sudo_cmd}apt-key add nginx_signing.key
${sudo_cmd}apt update && sudo apt -y upgrade
${sudo_cmd}apt install nginx
${sudo_cmd}systemctl start nginx
${sudo_cmd}systemctl enable nginx
${sudo_cmd}sed -i "2 s/nginx/www-data/" /etc/nginx/nginx.conf
${sudo_cmd}sed -i "3 s/1/$core/" /etc/nginx/nginx.conf
${sudo_cmd}sed -i "31i\ \ \ \ server_tokens off;\\n\\n\ \ \ \ index index.php index.html index.htm default-zonimi.html;\\n\\n\ \ \ \ location / {\\n\ \ \ \ \ \ \ \ try_files $uri $uri/ =404;\\n\ \ \ \ }\\n\\n\ \ \ \ location ~ /\.ht {\\n\ \ \ \ \ \ \ \ deny all;\\n\ \ \ \ }\\n\\n" /etc/nginx/nginx.conf

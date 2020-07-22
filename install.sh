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
${sudo_cmd}apt install unzip

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

cd /tmp
${sudo_cmd}wget https://github.com/h5bp/server-configs-nginx/archive/3.2.0.zip
${sido_cmd}unzip 3.2.0.zip
cd /tmp/server-configs-nginx-3.2.0
mv /tmp/server-configs-nginx-3.2.0/h5bp /etc/nginx
mv /tmp/server-configs-nginx-3.2.0/mime.types /etc/nginx

{  
  ${sudo_cmd}echo "# Configuration File - Nginx Server Configs"
  ${sudo_cmd}echo "# https://nginx.org/en/docs/"
  ${sudo_cmd}echo ""
  ${sudo_cmd}echo "user www-data;"
  ${sudo_cmd}echo ""
  ${sudo_cmd}echo "# https://nginx.org/en/docs/ngx_core_module.html#worker_processes"
  ${sudo_cmd}echo "worker_processes $core;"
  ${sudo_cmd}echo ""
  ${sudo_cmd}echo "# https://nginx.org/en/docs/ngx_core_module.html#worker_rlimit_nofile"
  ${sudo_cmd}echo "worker_rlimit_nofile 5000;"
  ${sudo_cmd}echo ""
  ${sudo_cmd}echo "events {"
  ${sudo_cmd}echo ""
  ${sudo_cmd}echo "  # https://nginx.org/en/docs/ngx_core_module.html#worker_connections"
  ${sudo_cmd}echo "  worker_connections 3072;"
  ${sudo_cmd}echo ""
  ${sudo_cmd}echo "}"
  ${sudo_cmd}echo ""
  ${sudo_cmd}echo "# https://nginx.org/en/docs/ngx_core_module.html#error_log"
  ${sudo_cmd}echo "error_log /var/log/nginx/error.log warn;"
  ${sudo_cmd}echo ""
  ${sudo_cmd}echo "# https://nginx.org/en/docs/ngx_core_module.html#pid"
  ${sudo_cmd}echo "pid /var/run/nginx.pid;"
  ${sudo_cmd}echo ""
  ${sudo_cmd}echo "http {"
  ${sudo_cmd}echo ""
  ${sudo_cmd}echo "  # Hide Nginx version information."
  ${sudo_cmd}echo "  include h5bp/security/server_software_information.conf;"
  ${sudo_cmd}echo ""
  ${sudo_cmd}echo "  # Specify media (MIME) types for files."
  ${sudo_cmd}echo "  include h5bp/media_types/media_types.conf;"
  ${sudo_cmd}echo ""
  ${sudo_cmd}echo "  # Set character encodings."
  ${sudo_cmd}echo "  include h5bp/media_types/character_encodings.conf;"
  ${sudo_cmd}echo ""
  ${sudo_cmd}echo "  # https://nginx.org/en/docs/http/ngx_http_log_module.html#log_format"
  ${sudo_cmd}echo "  log_format  main  \'\$remote_addr - \$remote_user [\$time_local] \"$request\" \'"
  ${sudo_cmd}echo "                    \'$status \$body_bytes_sent \"\$http_referer\" \'"
  ${sudo_cmd}echo "                    \'\"\$http_user_agent\" \"\$http_x_forwarded_for\"\';"
  ${sudo_cmd}echo ""
  ${sudo_cmd}echo "  # https://nginx.org/en/docs/http/ngx_http_log_module.html#access_log"
  ${sudo_cmd}echo "  access_log /var/log/nginx/access.log main;"
  ${sudo_cmd}echo ""
  ${sudo_cmd}echo "  # https://nginx.org/en/docs/http/ngx_http_core_module.html#keepalive_timeout"
  ${sudo_cmd}echo "  keepalive_timeout 20s;"
  ${sudo_cmd}echo ""
  ${sudo_cmd}echo "  # https://nginx.org/en/docs/http/ngx_http_core_module.html#sendfile"
  ${sudo_cmd}echo "  sendfile on;"
  ${sudo_cmd}echo ""
  ${sudo_cmd}echo "  # https://nginx.org/en/docs/http/ngx_http_core_module.html#tcp_nopush"
  ${sudo_cmd}echo "  tcp_nopush on;"
  ${sudo_cmd}echo ""
  ${sudo_cmd}echo "  # Enable gzip compression."
  ${sudo_cmd}echo "  include h5bp/web_performance/compression.conf;"
  ${sudo_cmd}echo ""
  ${sudo_cmd}echo "  # Specify file cache expiration."
  ${sudo_cmd}echo "  include h5bp/web_performance/cache_expiration.conf;"
  ${sudo_cmd}echo ""
  ${sudo_cmd}echo "  # Add X-XSS-Protection for HTML documents."
  ${sudo_cmd}echo "  map \$sent_http_content_type \$x_xss_protection {"
  ${sudo_cmd}echo "    ~*text/html \"1; mode=block\";"
  ${sudo_cmd}echo "  }"
  ${sudo_cmd}echo ""
  ${sudo_cmd}echo "  # Add X-Frame-Options for HTML documents."
  ${sudo_cmd}echo "  map \$sent_http_content_type \$x_frame_options {"
  ${sudo_cmd}echo "    ~*text/html DENY;"
  ${sudo_cmd}echo "  }"
  ${sudo_cmd}echo ""
  ${sudo_cmd}echo "  # Add Content-Security-Policy for HTML documents."
  ${sudo_cmd}echo "  map \$sent_http_content_type \$content_security_policy {"
  ${sudo_cmd}echo "    ~*text/(html|javascript)|application/pdf|xml \"default-src \'self\'; base-uri \'none\'; form-action \'self\'; frame-ancestors \'none\'; upgrade-insecure-requests\";"
  ${sudo_cmd}echo "  }"
  ${sudo_cmd}echo ""
  ${sudo_cmd}echo "  # Add Referrer-Policy for HTML documents."
  ${sudo_cmd}echo "  map \$sent_http_content_type \$referrer_policy {'
  ${sudo_cmd}echo "    ~*text/(css|html|javascript)|application\/pdf|xml \"strict-origin-when-cross-origin\";"
  ${sudo_cmd}echo "  }"
  ${sudo_cmd}echo ""
  ${sudo_cmd}echo "  # Add X-UA-Compatible for HTML documents."
  ${sudo_cmd}echo "  map \$sent_http_content_type \$x_ua_compatible {"
  ${sudo_cmd}echo "    ~*text/html \"IE=edge\";"
  ${sudo_cmd}echo "  }"
  ${sudo_cmd}echo ""
  ${sudo_cmd}echo "  # Add Access-Control-Allow-Origin."
  ${sudo_cmd}echo "  map \$sent_http_content_type \$cors {"
  ${sudo_cmd}echo "    # Images"
  ${sudo_cmd}echo "    ~*image/ \"*\";"
  ${sudo_cmd}echo ""
  ${sudo_cmd}echo "    # Web fonts"
  ${sudo_cmd}echo "    ~*font/                         \"*\";"
  ${sudo_cmd}echo "    ~*application/vnd.ms-fontobject \"*\";"
  ${sudo_cmd}echo "    ~*application/x-font-ttf        \"*\";"
  ${sudo_cmd}echo "    ~*application/font-woff         \"*\";"
  ${sudo_cmd}echo "    ~*application/x-font-woff       \"*\";"
  ${sudo_cmd}echo "    ~*application/font-woff2        \"*\";"
  ${sudo_cmd}echo "  }"
  ${sudo_cmd}echo ""
  ${sudo_cmd}echo "  include conf.d/*.conf;"
  ${sudo_cmd}echo ""
  ${sudo_cmd}echo "}"
 } > /etc/nginx/nginx.conf


{
  ${sudo_cmd}echo "server {"
  ${sudo_cmd}echo "  listen [::]:443 ssl http2;"
  ${sudo_cmd}echo "  listen 443 ssl http2;"
  ${sudo_cmd}echo ""
  ${sudo_cmd}echo "  server_name www.example.com;"
  ${sudo_cmd}echo ""
  ${sudo_cmd}echo "  include h5bp/ssl/ssl_engine.conf;"
  ${sudo_cmd}echo "  ssl_certificate /etc/letsencrypt/live/test.zonimi.me/fullchain.pem;"
  ${sudo_cmd}echo "  ssl_certificate_key /etc/letsencrypt/live/test.zonimi.me/privkey.pem;"
  ${sudo_cmd}echo "  include h5bp/ssl/policy_modern.conf;"
  ${sudo_cmd}echo ""
  ${sudo_cmd}echo "  return 301 \$scheme://example.com$request_uri;"
  ${sudo_cmd}echo "}"
  ${sudo_cmd}echo ""
  ${sudo_cmd}echo ""
  ${sudo_cmd}echo "server {"
  ${sudo_cmd}echo "  listen [::]:443 ssl http2;"
  ${sudo_cmd}echo "  listen 443 ssl http2;"
  ${sudo_cmd}echo ""
  ${sudo_cmd}echo "  # The host name to respond to"
  ${sudo_cmd}echo "  server_name example.com;"
  ${sudo_cmd}echo ""
  ${sudo_cmd}echo "  include h5bp/ssl/ssl_engine.conf;"
  ${sudo_cmd}echo "  include h5bp/ssl/certificate_files.conf;"
  ${sudo_cmd}echo "  include h5bp/ssl/policy_intermediate.conf;"
  ${sudo_cmd}echo ""
  ${sudo_cmd}echo "  # Path for static files"
  ${sudo_cmd}echo "  root /var/www/example.com/public;"
  ${sudo_cmd}echo ""
  ${sudo_cmd}echo "  # Custom error pages"
  ${sudo_cmd}echo "  include h5bp/errors/custom_errors.conf;"
  ${sudo_cmd}echo ""
  ${sudo_cmd}echo "  # Include the basic h5bp config set"
  ${sudo_cmd}echo "  include h5bp/basic.conf;"
  ${sudo_cmd}echo "}"
 } > /etc/nginx/conf.d/exemple.com.conf

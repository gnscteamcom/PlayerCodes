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

echo "work"

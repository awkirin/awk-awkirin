# Install / Update
```bash
  mkdir -p ~/bin && curl -L https://github.com/awkirin/awk-laravel-zero/releases/download/latest/awk-helper -o ~/bin/awk-helper && chmod +x ~/bin/awk-helper
```

Qqqq
```bash

  composer global config repositories.awk-awkwrap vcs https://github.com/awkirin/awk-awkwrap
  composer global require awkirin/awkwrap:dev-dev -W


  awk-helper completion zsh > "${HOME}/.oh-my-zsh/custom/completion-awk-helper.zsh"
 
  # Очистка кеша автокомплита
  rm -f "${HOME}/.zcompdump*"
```

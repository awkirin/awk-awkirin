# Install / Update
```bash
  mkdir -p ~/bin && curl -L https://github.com/awkirin/awk-awkwrap/releases/download/latest/awkwrap -o ~/bin/awkwrap && chmod +x ~/bin/awkwrap
```

Qqqq
```bash

  composer global config repositories.awk-awkwrap vcs https://github.com/awkirin/awk-awkwrap
  composer global require awkirin/awkwrap:dev-dev -W

  awkwrap completion zsh > "${HOME}/.oh-my-zsh/custom/completion-awkwrap.zsh" && rm -f ${HOME}/.zcompdump* | true && exec zsh
    
```

install dev
```bash
  echo 'alias awkwrap="'${PWD}'/awkwrap"' > "${HOME}/.oh-my-zsh/custom/dev-awkwrap.zsh"
```

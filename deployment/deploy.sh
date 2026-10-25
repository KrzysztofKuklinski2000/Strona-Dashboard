#!/bin/sh

set -eu

cd "$(dirname "$0")/.."

working_tree=$(/usr/local/bin/git status --porcelain)

if test -n "$working_tree"; then
  printf '%s\n' 'Deployment stopped: working tree is not clean.' >&2
  exit 1
fi

target_commit=${SSH_ORIGINAL_COMMAND:-}

if test "${#target_commit}" -ne 40; then
  printf '%s\n' 'Deployment stopped: invalid commit SHA.' >&2
  exit 1
fi

case "$target_commit" in
    *[!0-9a-f]*)
      printf '%s\n' 'Deployment stopped: invalid commit SHA.' >&2
      exit 1
      ;;
esac

/usr/local/bin/git fetch --no-tags origin master

#odczytuje pełne SHA najnowszego pobranego commitu
latest_commit=$(/usr/local/bin/git rev-parse refs/remotes/origin/master)

if test "$target_commit" != "$latest_commit"; then
  printf '%s\n' 'Deployment skipped: requested commit is not the current master.'
  exit 0
fi


/usr/local/bin/git merge --ff-only "$target_commit"

test "$(/usr/local/bin/git rev-parse HEAD)" = "$target_commit"

/usr/local/bin/php82 /usr/local/bin/composer install --no-dev --prefer-dist --optimize-autoloader --no-interaction

/usr/local/bin/php82 /usr/local/bin/composer check-platform-reqs --no-dev

printf  'Deployment completed: %s\n' "$target_commit"
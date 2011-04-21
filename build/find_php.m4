

AC_ARG_WITH(php,
[  --with-php=path         use this php interpreter to build the packages],[
  if test "$withval" != "no" -a "$withval" != "yes"; then
	PHP=$withval
  fi
])

if test -z "$PHP"; then
	AC_PATH_PROG([PHP], [php])
fi

if test ! -x "$PHP"; then
	AC_MSG_ERROR(PHP interpreter not found)
fi

AC_SUBST(PHP)

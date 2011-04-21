
AC_MSG_CHECKING(for PHPDoc)

PHPDOC=phpdoc
PHPDOC_RESULT='(from path)'

AC_ARG_WITH(phpdoc,
[  --with-phpdoc=DIR       phpdoc installation dir (used only to regenerate documentation)],[
	if test "$withval" != "no" -a "$withval" != "yes"; then
		PHPDOC="$withval/phpdoc"
		if test ! -x "$PHPDOC"; then
			AC_MSG_ERROR(phpdoc script not found ($PHPDOC))
		fi
		PHPDOC_RESULT=$PHPDOC
	fi
])

AC_MSG_RESULT($PHPDOC_RESULT)

AC_SUBST(PHPDOC)

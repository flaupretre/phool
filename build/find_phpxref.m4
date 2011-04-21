
AC_MSG_CHECKING(for PHPXref)

PHPXREF=''
PHPXREF_RESULT='(none)'

if test -x /opt/phpxref/phpxref.pl ; then
	PHPXREF=/opt/phpxref
	PHPXREF_RESULT=$PHPXREF
fi

AC_ARG_WITH(phpxref,
[  --with-phpxref=DIR      phpxref installation dir (used only to regenerate documentation)],[
	if test "$withval" != "no" -a "$withval" != "yes"; then
		PHPXREF="$withval"
		if test ! -x "$PHPXREF/phpxref.pl"; then
			AC_MSG_ERROR(Invalid phpxref directory ($PHPXREF))
		fi
		PHPXREF_RESULT=$PHPXREF
	fi
])

AC_MSG_RESULT($PHPXREF_RESULT)

AC_SUBST(PHPXREF)


AC_MSG_CHECKING(for PHK_Creator package)

AC_ARG_WITH(phkcreator,
[  --with-phkcreator=path  use this PHK_Creator package instead of the bundled one],[
  if test "$withval" != "no" -a "$withval" != "yes"; then
	PHK_CREATOR=$withval
	PHK_CREATOR_RESULT="$PHK_CREATOR"
  fi
])

if test -z "$PHK_CREATOR"; then
	_my_pwd=`pwd`
	cd $srcdir
	PHK_CREATOR=`pwd`/build/PHK_Creator.phk
	cd $_my_pwd
	PHK_CREATOR_RESULT=bundled
fi

AC_MSG_RESULT($PHK_CREATOR_RESULT)

AC_SUBST(PHK_CREATOR)

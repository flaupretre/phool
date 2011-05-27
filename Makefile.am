
SUBDIRS = doc

libexec_PROGRAMS = phool.phk

phool_phk_SOURCES = phool.psf \
	src/PHO_Display.php \
	src/PHO_File.php \
	src/PHO_Getopt.php \
	src/PHO_HTTP.php \
	src/PHO_IP.php \
	src/PHO_JSON.php \
	src/PHO_Modifiable.php \
	src/PHO_Persistent.php \
	src/PHO_Time.php \
	src/PHO_Util.php \
	src/PHO_VarContainer.php \
	src/PHO_XPage.php \
	COPYING

EXTRA_DIST = ACKNOWLEDGEMENTS NOTICE build/autogen.sh build/buildconf build/cleanup \
	build/debian.rules build/fix_perms  \
	build/PHK_Creator.phk build/reconfigure \
	build/@PACKAGE_NAME@-rpmlintrc build/xref.sh

RPM_BASE = /usr/src/redhat

rpm: dist
	cp $(DIST_ARCHIVES) $(RPM_BASE)/SOURCES
	rpmbuild -ba build/@PACKAGE_NAME@.spec $(RPM_BUILD_OPTS)
	/bin/rm -rf $(RPM_BASE)/SOURCES/$(DIST_ARCHIVES)
	/bin/rm -rf $(RPM_BASE)/BUILD/@PACKAGE_NAME@-@PACKAGE_VERSION@
	f=$(RPM_BASE)/RPMS/@ARCHITECTURE@/@PACKAGE_NAME@-@PACKAGE_VERSION@-@RELEASE_NUMBER@.@ARCHITECTURE@.rpm; \
	if [ -f $$f ] ; then cp $$f . ; /bin/rm -f $$f ; fi
	f=$(RPM_BASE)/RPMS/@ARCHITECTURE@/@PACKAGE_NAME@-debuginfo-@PACKAGE_VERSION@-@RELEASE_NUMBER@.@ARCHITECTURE@.rpm; \
	if [ -f $$f ] ; then cp $$f . ; /bin/rm -f $$f ; fi
	f=$(RPM_BASE)/SRPMS/@PACKAGE_NAME@-@PACKAGE_VERSION@-@RELEASE_NUMBER@.src.rpm; \
	if [ -f $$f ] ; then cp $$f . ; /bin/rm -f $$f ; fi

#------------------

.PHONY: docs clean_docs

phool.phk: $(phool_phk_SOURCES)
	$(PHK_CREATE) $@ phool.psf $(srcdir)/src

clean_docs:
	cd doc && $(MAKE) $@

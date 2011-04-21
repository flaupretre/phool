
EXTRA_DIST = $(TARGETS) $(API_PSF) $(XREF_PSF)

TMP_DIR = /tmp/.mk.tmp

SOURCE_DIR = $(top_srcdir)/src

TARGETS = $(API_PHK) $(API_PDF) $(XREF_PHK)

docs:  $(TARGETS)

clean_docs:
	/bin/rm -f $(TARGETS)

#------ API Documentation

API_PHK = @PACKAGE_NAME@_api.phk
API_PSF = api.psf
API_PDF = @PACKAGE_NAME@_api.pdf
API_PHPDOC_OPTS = -ti "@PACKAGE_DNAME@ API" -dc @PACKAGE_DNAME@ \
	-dn @PACKAGE_DNAME@ -d $(SOURCE_DIR) -t $(TMP_DIR)

$(API_PHK):
	/bin/rm -rf $(TMP_DIR); mkdir $(TMP_DIR)
	$(PHPDOC) -o HTML:frames:DOM/earthli $(API_PHPDOC_OPTS)
	cp $(top_srcdir)/COPYING $(TMP_DIR)/license.txt
	$(PHK_CREATE) $@ $(API_PSF) $(TMP_DIR)
	chmod +r $@

$(API_PDF):
	/bin/rm -rf $(TMP_DIR); mkdir $(TMP_DIR)
	$(PHPDOC) -o PDF:default:default $(API_PHPDOC_OPTS)
	mv $(TMP_DIR)/documentation.pdf $@
	/bin/rm -rf $(TMP_DIR)

#------ Cross Reference

XREF_PHK = @PACKAGE_NAME@_xref.phk
XREF_PSF = xref.psf
XREF_CFG = xref.cfg

$(XREF_PHK):
	/bin/rm -rf $(TMP_DIR); mkdir $(TMP_DIR)
	PHPXREF="$(PHPXREF)" INPUT="$(SOURCE_DIR)" OUTPUT="$(TMP_DIR)" \
			$(top_srcdir)/build/xref.sh $(XREF_CFG)
	cp $(top_srcdir)/COPYING $(TMP_DIR)/license.txt
	$(PHK_CREATE) $@ $(XREF_PSF) $(TMP_DIR)
	chmod +r $@
	/bin/rm -rf $(TMP_DIR)


include ../config.mk

TMP_DIR = /tmp/.mk.tmp

SOURCE_DIR = ../src

API_PHK = phool_api.phk
API_PSF = api.psf

XREF_PHK = phool_xref.phk
XREF_PSF = xref.psf
XREF_CFG = xref.cfg
XREF_SCRIPT = ../build/xref.sh

TARGETS = $(API_PHK) $(API_PDF) $(XREF_PHK)

PHK_CREATOR = ../build/PHK_Creator.phk
PHK_CREATE = $(PHP) $(PHK_CREATOR) build
EXPAND = ../build/expand.sh

#------

all: doc

doc: $(TARGETS)

clean:
	/bin/rm -f $(TARGETS) $(API_PSF) $(XREF_PSF)

.PHONY: doc clean_doc clean all

#------ API Documentation

$(API_PSF): $(API_PSF).in
		chmod +x $(EXPAND)
	SOFTWARE_VERSION=$(SOFWARE_VERSION) SOFTWARE_RELEASE=$(SOFTWARE_RELEASE) \
	$(EXPAND) <$< >$@

$(API_PHK): $(API_PSF)
	/bin/rm -rf $(TMP_DIR); mkdir $(TMP_DIR)
	$(PHPDOC) --template=clean --title "phool API" -d $(SOURCE_DIR) -t $(TMP_DIR)
	cp ../COPYING $(TMP_DIR)/license.txt
	$(PHK_CREATE) $@ $(API_PSF) $(TMP_DIR)
	chmod +r $@
	/bin/rm -rf $(TMP_DIR)

#------ Cross Reference

$(XREF_PSF): $(XREF_PSF).in
	chmod +x $(EXPAND)
	SOFTWARE_VERSION=$(SOFWARE_VERSION) SOFTWARE_RELEASE=$(SOFTWARE_RELEASE) \
		$(EXPAND) <$< >$@

$(XREF_PHK): $(XREF_PSF)
	/bin/rm -rf $(TMP_DIR); mkdir $(TMP_DIR)
	chmod +x $(XREF_SCRIPT)
	PHPXREF="$(PHPXREF)" INPUT="$(SOURCE_DIR)" OUTPUT="$(TMP_DIR)" \
			$(XREF_SCRIPT) $(XREF_CFG)
	cp ../COPYING $(TMP_DIR)/license.txt
	$(PHK_CREATE) $@ $(XREF_PSF) $(TMP_DIR)
	chmod +r $@
	/bin/rm -rf $(TMP_DIR)

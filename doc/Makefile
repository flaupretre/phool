
SOURCE_DIR = ../src
BUILD_DIR = ../build

CLASSES_DIR = ../src/classes
PUBLIC_API_CLASSES = PHO_Display PHO_File PHO_Getopt PHO_HTTP PHO_IP PHO_JSON \
	PHO_Modifiable PHO_Options PHO_Persistent PHO_Time PHO_Util PHO_VarContainer \
	PHO_XPage

TARGETS = api.phk api.pdf xref.phk
EXTRA_CLEAN = api.psf xref.psf

#------

include ../make.vars
include ../make.common

#------

.PHONY: clean

all: base

clean: clean_base

#------ API Documentation
#-- Restrict API documentation to the public API

api.phk: api.psf
	/bin/rm -rf $(TMP_DIR)
	mkdir -p $(TMP_DIR)/result $(TMP_DIR)/source
	for i in $(PUBLIC_API_CLASSES) ; do cp $(CLASSES_DIR)/$$i.php \
		$(TMP_DIR)/source ; done
	$(PHPDOC) -o HTML:frames:DOM/earthli -ti "$(PRODUCT) API" \
		-d $(TMP_DIR)/source -t $(TMP_DIR)/result
	$(PHK_BUILD) $@ -d SOURCE=$(TMP_DIR)/result
	/bin/rm -rf $(TMP_DIR)

#-- PDF

api.pdf: api.psf
	/bin/rm -rf $(TMP_DIR)
	mkdir -p $(TMP_DIR)/result $(TMP_DIR)/source
	for i in $(PUBLIC_API_CLASSES) ; do cp $(CLASSES_DIR)/$$i.php \
		$(TMP_DIR)/source ; done
	$(PHPDOC) -o PDF:default:default -ti "$(PRODUCT) API" \
		-d $(TMP_DIR)/source -t $(TMP_DIR)/result
	mv $(TMP_DIR)/result/documentation.pdf $@
	/bin/rm -rf $(TMP_DIR)

#-- Cross Reference

xref.phk: xref.psf
	/bin/rm -rf $(TMP_DIR)
	mkdir $(TMP_DIR)
	PHPXREF_DIR="$(PHPXREF_DIR)" INPUT="$(SOURCE_DIR)" OUTPUT="$(TMP_DIR)" \
			$(XREF) xref.cfg
	$(PHK_BUILD) $@ -d SOURCE=$(TMP_DIR)
	/bin/rm -rf $(TMP_DIR)


include ./config.mk

PHOOL_PHK = phool.phk
PHOOL_PSF = phool.psf

TARGETS = $(PHOOL_PHK)

PHK_CREATOR = build/PHK_Creator.phk
PHK_CREATE = $(PHP) $(PHK_CREATOR) build
EXPAND = build/expand.sh

#------

.PHONY: all clean doc clean_doc

all:  $(TARGETS)

clean: clean_doc
	/bin/rm -f $(TARGETS) $(PHOOL_PSF)

#------

$(PHOOL_PSF): $(PHOOL_PSF).in
	chmod +x $(EXPAND)
	SOFTWARE_VERSION=$(SOFTWARE_VERSION) SOFTWARE_RELEASE=$(SOFTWARE_RELEASE) \
		$(EXPAND) <$< >$@

$(PHOOL_PHK): $(PHOOL_PSF)
	$(PHK_CREATE) $@ phool.psf ./src

#------

doc:
	$(MAKE) -C doc

clean_doc:
	$(MAKE) -C doc clean


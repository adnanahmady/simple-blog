#!make
mainShell=bash
mainService=app
compose=docker compose

define default
$(if $(1),$(1),$(2))
endef

define execute
$(compose) exec $(call default,$1,${mainService}) $2
endef

up:
	@$$(touch .src/bash_history)
	@$(compose) up -d ${options}

build:
	${MAKE} up options=$(call default,--build,${options})

down:
	@$(compose) down

ps: status
status:
	@$(compose) ps

destroy:
	@$(compose) down --volumes --remove-orphans

shell:
	@$(call execute,${service},$(call default,${run},${mainShell}))

myt:
	echo $(if ${follow},-f,)

logs:
	@$(compose) logs ${service} $(if follow,-f,)

test:
	@$(call execute,${service},composer test)

coverage:
	@$(call execute,${service},composer coverage)

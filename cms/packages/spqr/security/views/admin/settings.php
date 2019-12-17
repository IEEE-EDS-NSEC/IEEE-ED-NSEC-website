<?php $view->script('settings', 'spqr/security:app/bundle/settings.js',
    ['vue']); ?>

<div id="settings" class="uk-form uk-form-horizontal" v-cloak>
	<div class="uk-grid pk-grid-large" data-uk-grid-margin>
		<div class="pk-width-sidebar">
			<div class="uk-panel">
				<ul class="uk-nav uk-nav-side pk-nav-large"
				    data-uk-tab="{ connect: '#tab-content' }">
					<li>
						<a><i class="pk-icon-large-settings uk-margin-right"></i> {{ 'General' | trans }}</a>
					</li>
					<li>
						<a><i class="pk-icon-large-meta uk-margin-right"></i> {{ 'Jails' | trans }}</a>
					</li>
					<li>
						<a><i class="uk-icon-puzzle-piece uk-margin-right"></i> {{ 'Whitelist' | trans }}</a>
					</li>
				</ul>
			</div>
		</div>
		<div class="pk-width-content">
			<ul id="tab-content" class="uk-switcher uk-margin">
				<li>
					<div class="uk-margin uk-flex uk-flex-space-between uk-flex-wrap"
					     data-uk-margin>
						<div data-uk-margin>
							<h2 class="uk-margin-remove">{{ 'General' | trans }}</h2>
						</div>
						<div data-uk-margin>
							<button class="uk-button uk-button-primary"
							        @click.prevent="save">{{ 'Save' | trans }}
							</button>
						</div>
					</div>
				</li>
				<li>
					<div class="uk-margin uk-flex uk-flex-space-between uk-flex-wrap"
					     data-uk-margin>
						<div data-uk-margin>
							<h2 class="uk-margin-remove">{{ 'Jails' | trans }}</h2>
						</div>
						<div data-uk-margin>
							<button class="uk-button uk-button-primary"
							        @click.prevent="save">{{ 'Save' | trans }}
							</button>
						</div>
					</div>
					<div class="uk-form-row">
						<label for="form-loginjail"
						       class="uk-form-label">{{ 'Enable Login Jail' | trans
							}}</label>
						<div class="uk-form-controls uk-form-controls-text">
							<input id="form-loginjail" type="checkbox"
							       v-model="config.jails.login.enabled">
						</div>
					</div>
					<div class="uk-form-row" v-if="config.jails.login.enabled">
						<label for="form-loginattempts"
						       class="uk-form-label">{{ 'Number of attempts' | trans
							}}</label>
						<div class="uk-form-controls uk-form-controls-text">
							<p class="uk-form-controls-condensed">
								<input id="form-loginattempts" type="number"
								       class="uk-form-width-large"
								       v-model="config.jails.login.attempts"
								       min="0" number>
							</p>
						</div>
					</div>
					<div class="uk-form-row">
						<label for="form-unauthorizedjail"
						       class="uk-form-label">{{ 'Enable Unauthorized
							Jail' | trans
							}}</label>
						<div class="uk-form-controls uk-form-controls-text">
							<input id="form-unauthorizedjail" type="checkbox"
							       v-model="config.jails.unauthorized.enabled">
						</div>
					</div>
					<div class="uk-form-row"
					     v-if="config.jails.unauthorized.enabled">
						<label for="form-unauthorizedattempts"
						       class="uk-form-label">{{ 'Number of attempts' | trans
							}}</label>
						<div class="uk-form-controls uk-form-controls-text">
							<p class="uk-form-controls-condensed">
								<input id="form-unauthorizedattempts" type="number"
								       class="uk-form-width-large"
								       v-model="config.jails.unauthorized.attempts"
								       min="0" number>
							</p>
						</div>
					</div>
					<div class="uk-form-row">
						<label for="form-forbiddenjail"
						       class="uk-form-label">{{ 'Enable Forbidden Jail' | trans
							}}</label>
						<div class="uk-form-controls uk-form-controls-text">
							<input id="form-forbiddenjail" type="checkbox"
							       v-model="config.jails.forbidden.enabled">
						</div>
					</div>
					<div class="uk-form-row"
					     v-if="config.jails.forbidden.enabled">
						<label for="form-forbiddenattempts"
						       class="uk-form-label">{{ 'Number of attempts' | trans
							}}</label>
						<div class="uk-form-controls uk-form-controls-text">
							<p class="uk-form-controls-condensed">
								<input id="form-forbiddenattempts" type="number"
								       class="uk-form-width-large"
								       v-model="config.jails.forbidden.attempts"
								       min="0" number>
							</p>
						</div>
					</div>
					<div class="uk-form-row">
						<label for="form-honeypotjail"
						       class="uk-form-label">{{ 'Enable Honeypot Jail' | trans
							}}</label>
						<div class="uk-form-controls uk-form-controls-text">
							<input id="form-honeypotjail" type="checkbox"
							       v-model="config.jails.honeypot.enabled">
						</div>
					</div>
					<div class="uk-form-row"
					     v-if="config.jails.honeypot.enabled">
						<label for="form-honeypotjail"
						       class="uk-form-label">{{ 'Number of attempts' | trans
							}}</label>
						<div class="uk-form-controls uk-form-controls-text">
							<p class="uk-form-controls-condensed">
								<input id="form-honeypotjail" type="number"
								       class="uk-form-width-large"
								       v-model="config.jails.honeypot.attempts"
								       min="0" number>
							</p>
						</div>
					</div>
					<div class="uk-form-row"
					     v-if="config.jails.honeypot.enabled">
						<label for="form-honeypots"
						       class="uk-form-label">{{ 'Honeypot URLs' | trans}}</label>
						<div class="uk-form-controls uk-form-controls-text">
							<p class="uk-form-controls-condensed">
								<a class="uk-button"
								   @click.prevent="editHoneypots()"><i
											class="uk-icon-list"></i></a>
							</p>
						</div>
					</div>
					<div class="uk-form-row">
						<label for="form-spamjail"
						       class="uk-form-label">{{ 'Enable Spam Jail' | trans
							}}</label>
						<div class="uk-form-controls uk-form-controls-text">
							<input id="form-spamjail" type="checkbox"
							       v-model="config.jails.spam.enabled">
						</div>
					</div>
					<div class="uk-form-row" v-if="config.jails.spam.enabled">
						<label for="form-spamattempts"
						       class="uk-form-label">{{ 'Number of attempts' | trans
							}}</label>
						<div class="uk-form-controls uk-form-controls-text">
							<p class="uk-form-controls-condensed">
								<input id="form-spamattempts" type="number"
								       class="uk-form-width-large"
								       v-model="config.jails.spam.attempts"
								       min="0" number>
							</p>
						</div>
					</div>
				</li>
				<li>
					<div class="uk-margin uk-flex uk-flex-space-between uk-flex-wrap"
					     data-uk-margin>
						<div data-uk-margin>
							<h2 class="uk-margin-remove">{{ 'Whitelist' | trans }}</h2>
						</div>
						<div data-uk-margin>
							<button class="uk-button uk-button-primary"
							        @click.prevent="save">{{ 'Save' | trans }}
							</button>
						</div>
					</div>
					<form class="uk-form uk-form-stacked"
					      v-validator="formWhitelist"
					      @submit.prevent="add | valid">
						<div class="uk-form-row">
							<div class="uk-grid" data-uk-margin>
								<div class="uk-width-large-1-2">
									<input class="uk-input-large"
									       type="text"
									       placeholder="{{ 'IP' | trans }}"
									       name="whitelist"
									       v-model="newWhitelist"
									       v-validate:required>
									<p class="uk-form-help-block uk-text-danger"
									   v-show="formWhitelist.whitelist.invalid">
										{{ 'Invalid value.' | trans }}</p>
								</div>
								<div class="uk-width-large-1-2">
									<div class="uk-form-controls">
										<span class="uk-align-right">
											<button class="uk-button"
											        @click.prevent="addIP | valid">
												{{ 'Add' | trans }}
											</button>
										</span>
									</div>
								</div>
							</div>
						</div>
					</form>
					<hr/>
					<div class="uk-alert"
					     v-if="!config.whitelist.length">{{ 'You can add your first whitelist entry using the input
						field above. Go ahead!' | trans }}
					</div>
					<ul class="uk-list uk-list-line"
					    v-if="config.whitelist.length">
						<li v-for="ip in config.whitelist">
							<input class="uk-input-large"
							       type="text"
							       placeholder="{{ 'IP' | trans }}"
							       v-model="ip">
							<span class="uk-align-right">
								<button @click="removeIP(ip)"
								        class="uk-button uk-button-danger">
									<i class="uk-icon-remove"></i>
								</button>
							</span>
						</li>
					</ul>
				</li>
			</ul>
		</div>
	</div>
	<v-modal v-ref:modal>
		<form class="uk-form uk-form-stacked" v-validator="formHoneypot"
		      @submit.prevent="addHoneypot |	valid">
			<div class="uk-modal-header">
				<h2>{{ 'Edit Honeypots' | trans }}</h2>
			</div>
			<div class="uk-grid" data-uk-margin>
				<div class="uk-width-large-1-2">
					<input class="uk-input-large"
					       type="text"
					       placeholder="{{ 'URL' | trans }}"
					       name="honeypot"
					       v-model="newHoneypotUrl"
					       v-validate:required>
					<p class="uk-form-help-block uk-text-danger"
					   v-show="formHoneypot.honeypot.invalid">
						{{ 'Invalid value.' | trans }}</p>
				</div>
				<div class="uk-width-large-1-2">
					<div class="uk-form-controls">
						<span class="uk-align-right">
							<button class="uk-button"
							        @click.prevent="addHoneypot | valid">
								{{ 'Add' | trans }}
							</button>
						</span>
					</div>
				</div>
			</div>
		</form>
		<hr/>
		<div class="uk-alert"
		     v-if="!config.jails.honeypot.honeypots.length">{{ 'You can add your first honeypot URL entry
			using the input
			field above. Go ahead!' | trans }}
		</div>
		<ul class="uk-list uk-list-line uk-form"
		    v-if="config.jails.honeypot.honeypots.length">
			<li v-for="honeypot in config.jails.honeypot.honeypots">
				<input class="uk-input-large"
				       type="text"
				       placeholder="{{ 'URL' | trans }}"
				       v-model="honeypot">
				<span class="uk-align-right">
					<button @click="removeHoneypot(honeypot)"
					        class="uk-button uk-button-danger">
						<i class="uk-icon-remove"></i>
					</button>
				</span>
			</li>
		</ul>
		<div class="uk-modal-footer uk-text-right">
			<button class="uk-button uk-button-link uk-modal-close"
			        type="button">{{ 'Close' | trans }}
			</button>
		</div>
	</v-modal>
</div>
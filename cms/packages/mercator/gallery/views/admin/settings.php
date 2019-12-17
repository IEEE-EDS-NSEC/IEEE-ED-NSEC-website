<?php $view->script( 'settings', 'mercator/gallery:app/bundle/settings.js', ['vue', 'uikit']); ?>

<div id="settings" class="uk-grid pk-grid-large" data-uk-grid-margin v-cloak>
		<div class="pk-width-sidebar">
			<div class="uk-panel">
				<ul class="uk-nav uk-nav-side pk-nav-large" data-uk-tab="{ connect: '#tab-content' }">
					<li class="uk-active"><a><i class="pk-icon-large-settings uk-margin-right"></i> {{ 'Settings' | trans }}</a></li>
					<li><a><i class="pk-icon-large-code uk-margin-right"></i> {{ 'Informations' | trans }}</a></li>
					<li><a><i class="pk-icon-large-bolt uk-margin-right"></i> {{ 'Options' | trans }}</a></li>
				</ul>
			</div>

		</div>

		<div class="pk-width-content">
			<ul id="tab-content" class="uk-switcher uk-margin">
				<li>
					<div class="uk-margin uk-flex uk-flex-space-between uk-flex-wrap" data-uk-margin>
						<div data-uk-margin>
							<h2 class="uk-margin-remove">{{ 'General Settings' | trans }}</h2>
						</div>
						<div data-uk-margin>
							<button class="uk-button uk-button-primary" @click.prevent="save">{{ 'Save' | trans }}
							</button>
						</div>
					</div>
					<div class="uk-form-row">
						<label for="form-caching" class="uk-form-label">{{ 'Settings Dummy' | trans }}</label>
						<div class="uk-form-controls uk-form-controls-text">
							<input id="form-caching" type="checkbox" v-model="config.caching">
						</div>
					</div>
				</li>
				<li>

					<div class="uk-margin uk-flex uk-flex-space-between uk-flex-wrap" data-uk-margin>
						<div data-uk-margin>
							<h2 class="uk-margin-remove">{{ 'General Informations' | trans }}</h2>
						</div>

					</div>
					<div class="uk-form-row">
						<h3>{{ 'Usage Information:' | trans }}</h3>
						<hr>
						<div class="uk-form-controls uk-form-controls-text">
							<ul class="uk-list uk-list-line">
								<li>{{ 'Create a directory with the name "Images" within your storage folder' | trans }}</li>
								<li>{{ 'For each slideshow you want to produce, create a subdirectory within your Images folder' | trans }}<br /> {{ 'Example' | trans }}: <b>show1</b></li>
								<li>{{ 'To include a preview of your images into your page, simply use the following widget code:' | trans }} <b>(mercator_gallery){"dir":"show1"}</b></li>
								<li>{{ 'The script will do the magic and automatically produce a preview of the images' | trans }}</li>
							</ul>
						</div>
					</div>
				</li>
				<li>
					<div class="uk-form-row">
						<h2 class="uk-margin-remove">{{ 'Advanced Options:' | trans }}</h2>
						<div class="uk-form-controls uk-form-controls-text">
							<p><h3>{{ 'Adding advanced options is easy (add them seprated with commata in your widget code)' | trans }}</h3></p>
							<p><h4>{{ 'Following Advanced Options are available:' | trans }} </h4></p>
							<p>
							<table class="uk-table uk-table-hover">
								<tr>
									<td class=" pk-table-width-150 uk-text-nowrap"><h5>{{ 'Example Widget Code:' | trans }}</h5></td>
									<td class="pk-table-text-break"><b>{{ '(mercator_gallery){"dir":"show1","fullscreen":"false"}' | trans }}</b></td>
								</tr>
							</table>
							</p>
							<div class="uk-overflow-container">
								<table class="uk-table uk-table-hover">
									<thead>
										<tr>
											<th class="pk-table-width-150">{{ 'Options' | trans }}</th>
											<th>{{ 'Description' | trans }}</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td class="uk-text-nowrap">{{ '"mode":"carousel"' }}</td>
											<td class="pk-table-text-break">{{ 'Do not show thumbnails, but produce a Carousel (see Blueimp Gallery Documentation)' | trans }}</td>
										</tr>
										<tr>
											<td class="uk-text-nowrap">{{ '"duration":"300"' }}</td>
											<td class="pk-table-text-break">{{ 'Change the duration (in ms) each image is shown, e.g., 300ms.' | trans }}</td>
										</tr>
										<tr>
											<td class="uk-text-nowrap">{{ '"fullscreen":"false"' }}</td>
											<td class="pk-table-text-break">{{ 'When clicking on thumbs, a slideshow will start. By default it starts fullscreen. When set to false, the show will run in the current window.' | trans }}</td>
										</tr>
										<tr>
											<td class="uk-text-nowrap">{{ '"postion":"uk-width-1-2"' }}</td>
											<td class="pk-table-text-break">{{ 'When using a carousel, you can use and UIKit multiple width statements to determine the and positioning of the carousel. If not specified, it is uk-width-1-2 uk-container-center' | trans }}</td>
										</tr>
									</tbody>
								 </table>
							 </div>

						</div>
					</div>

				</li>
			</ul>
		</div>
</div>

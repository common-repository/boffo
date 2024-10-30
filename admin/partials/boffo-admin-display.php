<?php
/**
 * @link       https://yorkstreetlabs.com
 * @since      1.0.0
 *
 * @package    Boffo
 * @subpackage Boffo/admin/partials
 */
?>

<div class="wrap">
    <div id="boffo-views">
        <h1 class="wp-heading-inline">Boffo</h1>
        <a v-on:click="addForm()" class="page-title-action">Add Flow</a>
        <small>v<?php echo $this->version; ?></small>
        <hr class="wp-header-end">
        <div class="toast"></div>
        
        <div class="boffo-view" v-bind:class="{ active: currentView == 'listView' }">
            <boffo-list-view v-on:edit-form="loadFormDetails" ref="listView"></boffo-list-view>
        </div>
        <div class="boffo-view" v-bind:class="{ active: currentView == 'detailView' }">
            <boffo-detail-view v-bind:form="currentForm" v-on:edit-form="loadFormDetails" v-on:cancel="showListView"></boffo-detail-view>
        </div>
    </div>
</div>

<script id="boffo-list-template" type="text/x-template">
    <div id="boffo-list-view">
        <h2>Flows</h2>
        <ul>
            <li v-for="form, formKey in forms">
                <button v-on:click="deleteForm(form, formKey)" class="delete-form-button"><span class="dashicons dashicons-minus"></span></button>
                <a v-on:click="editForm(form)">{{ form.title }}</a>
                <div class="flow-integration-box">
                    <div>
                        <h4>Using a shortcode?</h4>
                        <ol>
                            <li>Copy this shortcode snippet <code>[boffo_flow id="{{ form.id }}"]</code></li>
                            <li>Paste snippet into your post or page editor.</li>
                        </ol>
                    </div>
                    <div>
                        <h4>Using a Gutenberg block?</h4>
                        <ol>
                            <li>Copy this Boffo flow id <code>{{ form.id }}</code></li>
                            <li>Open up your editor and add a new "Boffo block".</li>
                            <li>Paste into the Boffo Flow ID field under "Block" settings.</li>
                        </ol>
                    </div>
                </div>
                
            </li>
        </ul>
        <div v-if="!forms || forms.length < 1">
            It looks like there are no flows in the system. <a v-on:click="addForm()">Get started creating your first</a>.
        </div>
    </div>
</script>

<script id="boffo-detail-template" type="text/x-template">
    <div id="boffo-detail-view">
        <h2><a v-on:click="cancel()">Flows</a> > Flow Editor</h2>

        <div class="boffo-detail-view-box" v-if="form.items">
            <div>
                <input type="text" v-model="form.title" placeholder="Flow title" ref="titleInput">

                <div class="boffo-form-settings">
                    <h3>Settings</h3>
                    <label for="boffoDeliveryMethod">How do you want to be notified?</label>
                    <select ref="deliveryMethodInput" id="boffoDeliveryMethod" v-model="form.delivery_method">
                        <option value="email">By email to <?php echo get_bloginfo('admin_email');?></option>
                        <option value="mailchimp" disabled>By Slack (pro)</option>
                        <option value="zapier" disabled>By Zapier (pro)</option>
                        <option value="twilio" disabled>By Twilio SMS (pro)</option>
                    </select>
                    <label for="boffoSubmitButtonText">Submit button text</label>
                    <input type="text" id="boffoSubmitButtonText" v-model="form.submit_button_text" placeholder="Submit button text" ref="submitButtonTextInput">
                    <label for="boffoConfirmationMessage">Confirmation message text</label>
                    <input type="text" id="boffoConfirmationMessage" v-model="form.confirmation_message" placeholder="Confirmation message" ref="confirmationMessageInput">
                </div>

                <div class="boffo-form-items">
                    <h3>Steps</h3>
                    <div v-if="form.items.length == 0" class="boffo-form-blank-message">
                        Let's get started adding some steps, <a v-on:click="addItem()">create your first one</a>.
                    </div>
                    <div v-for="item, objKey in form.items" v-bind:class="{ active: activeItem == objKey }">
                        <div class="boffo-form-item-edit-state">
                            <button v-on:click="deleteItem(objKey)" class="delete-item-button"><span class="dashicons dashicons-minus"></span></button>
                            <input type="text" v-model="item.text" ref="itemTextInput" placeholder="Write your lead-in copy for this step">
                            <div class="boffo-form-item-type-box">
                                <label>Field type</label>
                                <ul>
                                    <li v-on:click="item.type = 'text'" v-bind:class="{ active: item.type == 'text' }">
                                        <span class="dashicons dashicons-editor-paragraph"></span>
                                        Text
                                    </li>
                                    <li v-on:click="item.type = 'email'" v-bind:class="{ active: item.type == 'email' }">
                                        <span class="dashicons dashicons-email"></span>
                                        Email
                                    </li>
                                    <li v-on:click="item.type = 'select'" v-bind:class="{ active: item.type == 'select' }">
                                        <span class="dashicons dashicons-menu"></span>
                                        Dropdown
                                    </li>
                                </ul>
                                <div class="boffo-form-item-settings">
                                    <label>Settings</label>
                                    <input type="text" class="boffo-placeholder-input" v-model="item.placeholder" placeholder="Placeholder text" />
                                </div>
                                <div class="boffo-form-item-options" v-if="item.type === 'select'">
                                    <label>Options</label>
                                    <div v-for="option, itemKey in item.options">
                                        <button v-if="itemKey > 0" v-on:click="deleteOption(item, itemKey)" class="delete-option-button"><span class="dashicons dashicons-minus"></span></button>
                                        <input placeholder="Write your option" v-model="option.text" type="text" ref="optionTextInput">
                                    </div>
                                    <button v-on:click="addOption(item)" class="add-option-button button button-small">+ Option</button>
                                </div>
                            </div>
                        </div>
                        <div class="boffo-form-item-view-state">
                            <a v-on:click="editItem(objKey)">{{ item.text }} <span>{{ item.type }}</span></a>
                        </div>
                    </div>
                </div>

                <button v-if="form.items.length > 0" v-on:click="addItem()" class="button">+ Step</button>

                <div>
                    <button v-on:click="cancel()" class="button button-large">Cancel</button>
                    <button v-on:click="save(form)" class="button button-primary button-large">Save</button>
                </div>
            </div>
        </div>
    </div>
</script>
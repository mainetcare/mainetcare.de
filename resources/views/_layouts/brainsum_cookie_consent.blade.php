<script src="/js/cookieconsent.js"></script>
<script>
    window.CookieConsent.init({
        // More link URL on bar
        modalMainTextMoreLink: null,
        // How lond to wait until bar comes up
        barTimeout: 1000,
        // Look and feel
        theme: {
            barColor: '#F0EEE9',
            barTextColor: '#292F32',
            barMainButtonColor: '#BC9338',
            barMainButtonTextColor: '#292F32',
            modalMainButtonColor: '#BC9338',
            modalMainButtonTextColor: '#292F32',
        },
        language: {
            // Current language
            current: 'de',
            locale: {
                de: {
                    barMainText: '',
                    barLinkSetting: 'Cookie Einstellungen',
                    barBtnAcceptAll: 'Alle cookies akzeptieren',
                    modalMainTitle: 'Cookie Einstellungen',
                    modalMainText: 'Cookies sind kleine Datenpakete, die Ihr Web-Browser für einen mehrtätigen Zeitraum abspeichert.',
                    modalBtnSave: 'Speichern',
                    modalBtnAcceptAll: 'Alle Cookies',
                    modalAffectedSolutions: 'Betroffene Lösungen:',
                    learnMore: 'Mehr erfahren',
                    on: 'An',
                    off: 'Aus',
                }
            }
        },
        // List all the categories you want to display
        categories: {
            // Unique name
            // This probably will be the default category
            necessary: {
                // The cookies here are necessary and category cant be turned off.
                // Wanted config value  will be ignored.
                needed: true,
                // The cookies in this category will be let trough.
                // This probably should be false if not necessary category
                wanted: true,
                // If the checkbox is on or off at first run.
                checked: true,
                // Language settings for categories
                language: {
                    locale: {
                        en: {
                            name: 'Strictly Necessary Cookies',
                            description: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur eu commodo est, nec gravida odio. Suspendisse scelerisque a ex nec semper.',
                        },
                        de: {
                            name: 'Notwendige Cookies',
                            description: 'Diese Cookies sind für den Betrieb der Website notwendig, z.B. den Betrieb des Warenkorbs.',
                        }
                    }
                }
            },
            benutzeranalyse: {
                // The cookies here are necessary and category cant be turned off.
                // Wanted config value  will be ignored.
                needed: false,
                // The cookies in this category will be let trough.
                // This probably should be false if not necessary category
                wanted: true,
                // If the checkbox is on or off at first run.
                checked: true,
                // Language settings for categories
                language: {
                    locale: {
                        de: {
                            name: 'Benutzeranalysen',
                            description: 'Benutzeranalysen helfen uns, die Anwendung zu verbessern. Wir verwenden Matomo auf unseren eigenen Servern, es werden keine Drittanbieter benutzt.',
                        }
                    }
                }
            }
        },
        // List actual services here
        services: {
            // Unique name
            matomo: {
                // Existing category Unique name
                // This example shows how to block Google Analytics
                category: 'benutzeranalyse',
                // Type of blocking to apply here.
                // This depends on the type of script we are trying to block
                // Can be: dynamic-script, script-tag, wrapped, localcookie
                type: 'localcookie',
                // Only needed if "type: dynamic-script"
                // The filter will look for this keyword in inserted scipt tags
                // and block if match found
                search: '',
                // List of known cookie names or Regular expressions matching
                // cookie names placed by this service.
                // These willbe removed from current domain and .domain.
                cookies: [
                    {
                        // Known cookie name.
                        name: '_pw',
                        // Expected cookie domain.
                        domain: `.${window.location.hostname}`
                    },
                    {
                        // Regex matching cookie name.
                        name: /^_ga/,
                        domain: `.${window.location.hostname}`
                    }
                ],
                language: {
                    locale: {
                        en: {
                            name: 'Matomo Benuteranalyse'
                        },
                        de: {
                            name: 'Matomo Benutzeranalyse'
                        }
                    }
                }
            }
        }
    });
</script>

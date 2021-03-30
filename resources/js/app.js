import 'alpinejs';
import {createPopper} from '@popperjs/core';
import Litepicker from 'litepicker'


window.Litepicker = Litepicker;
window.createPopper = createPopper;

window.dropdown = function ({overlay = true, showpicker = false} = {}) {
    return {
        showpicker: showpicker,
        open() {
            this.showpicker = true;
            window.dispatchEvent(new CustomEvent('opendropdown'));
            this.$nextTick(() => {
                this.updatePopper()
            })
            this.toggleOverlay(this.showpicker);
        },
        close() {
            this.showpicker = false;
            this.toggleOverlay(this.showpicker);
        },
        toggleOverlay(state) {
            // this.updatePopper();
            if (overlay) {
                window.dispatchEvent(new CustomEvent('overlay', {detail: state}));
            }
        },
        updatePopper() {
            if (typeof poppi !== 'undefined' && poppi.length > 0) {
                poppi.forEach(popper => {
                    popper.update();
                });
            }
        },
        listen() {
            window.livewire.on('refreshCart', () => {
                this.close()
            })
        }
    }
}

window.overlay = function () {
    return {
        open: false,
        toggle(customevent) {
            this.open = customevent.detail
        },
        close() {
            this.open = false
        },
        listen() {
            window.livewire.on('refreshCart', () => {
                this.close()
            })
        }
    }
}

window.toasthandler = function () {
    return {
        show: false,
        notices: [],
        visible: [],
        add(notice) {
            notice.id = Date.now()
            this.notices.push(notice)
            this.fire(notice.id)
        },
        fire(id) {
            let notice = this.notices.find(notice => notice.id === id);
            let dur = notice.dur ? notice.dur : 2000;
            this.show = true;
            this.visible.push(notice)
            const timeShown = dur * this.visible.length
            setTimeout(() => {
                this.remove(id)
            }, timeShown)
        },
        remove(id) {
            const notice = this.visible.find(notice => notice.id === id)
            const index = this.visible.indexOf(notice)
            this.visible.splice(index, 1)
        },

    };
}

window.calcHeader = function () {
    // hardcode some elements that need specific height:
    // [...document.querySelectorAll('header:visible')].forEach(function(element) {
    //     element.style.height = element.offsetHeight + 'px';
    // });
    // create space for fixed header:
    let header = document.getElementById('header')
    if (header) {
        header.style.height = null;
        header.style.position = 'fixed';
        header.style.height = header.offsetHeight + 'px';
        let spacer = document.getElementById('headerspacer')
        if (spacer) {
            spacer.style.height = header.offsetHeight + 'px';
        }
    }
}


window.initpopper = function () {
    window.poppi = [];
    let els = document.querySelectorAll("[data-droptrig]")
    els.forEach(el => {
        let panel = el.querySelector("[data-panel]")
        if (panel) {
            let pop = createPopper(
                el,
                panel, {
                    modifiers: [
                        {
                            name: 'offset',
                            options: {
                                offset: [0, 8],
                            },
                        },
                    ],
                }
            );
            poppi.push(pop);
        }
    })
}

window.onload = function () {
    calcHeader();
    initpopper();
    let errori = document.querySelectorAll("#PageError [data-errormessage]")
    if (errori.length > 0) {
        errori.forEach(el => {
            window.dispatchEvent(new CustomEvent('ltoast',
                {
                    'detail': {
                        'type': 'error',
                        'message': el.dataset.errormessage,
                        'dur': 4000
                    }
                }
                )
            );
        })
    }

};

window.livewire.on('initpopper', () => {
    initpopper();
})


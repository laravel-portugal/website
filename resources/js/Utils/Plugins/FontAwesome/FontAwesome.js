import { library } from '@fortawesome/fontawesome-svg-core'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import {
    faInstagram,
    faFacebook,
    faTwitter,
    faDiscord,
    faMeetup,
    faGithub,
    faYoutube
} from '@fortawesome/free-brands-svg-icons'

export function FontAwesomeRegister(){
    library.add(
        faInstagram,
        faFacebook,
        faTwitter,
        faDiscord,
        faMeetup,
        faGithub,
        faYoutube
    )
}

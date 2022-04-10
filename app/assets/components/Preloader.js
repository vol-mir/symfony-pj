
import React from 'react'
import PropTypes from 'prop-types'
import { Image } from '@themesberg/react-bootstrap'

import ReactLogo from '../assets/img/technologies/react-logo-transparent.svg'

class Preloader extends React.Component {
    render () {
        const { show } = this.props

        return (
            <div className={`preloader bg-soft flex-column justify-content-center align-items-center ${show ? '' : 'show'}`}>
                <Image className='loader-element animate__animated animate__jackInTheBox' src={ReactLogo} height={40} />
            </div>
        )
    }
}

Preloader.propTypes = {
    show: PropTypes.bool
}

export default Preloader

import React, { useState, useEffect } from 'react'
import { Route, Switch } from 'react-router-dom'
import { RoutesApp } from '../routes'
import PropTypes from 'prop-types'

// components
import Sidebar from '../components/Sidebar'
import Navbar from '../components/Navbar'
import Preloader from '../components/Preloader'
import Footer from '../components/Footer'

// pages
import Home from './Home'
import About from './About'
import Tables from './tables/BootstrapTables'
import TestTables from './tables/TestTables'

const RouteWithSidebar = ({ component: Component, ...rest }) => {
    const [loaded, setLoaded] = useState(false)

    useEffect(() => {
        const timer = setTimeout(() => setLoaded(true), 1000)
        return () => clearTimeout(timer)
    }, [])

    const localStorageIsSettingsVisible = () => {
        return localStorage.getItem('settingsVisible') !== 'false'
    }

    const [showSettings, setShowSettings] = useState(localStorageIsSettingsVisible)

    const toggleSettings = () => {
        setShowSettings(!showSettings)
        localStorage.setItem('settingsVisible', !showSettings)
    }

    return (
        <Route {...rest} render={props => (
            <React.Fragment>
                <Preloader show={!loaded} />
                <Sidebar />

                <main className="content">
                    <Navbar />
                    <Component {...props} />
                    <Footer toggleSettings={toggleSettings} showSettings={showSettings} />
                </main>
            </React.Fragment>
        )}
        />
    )
}

RouteWithSidebar.propTypes = {
    component: PropTypes.any
}

export default function HomePage () {
    return (
        <Switch>
            <RouteWithSidebar exact path={RoutesApp.About.path} component={About} />
            <RouteWithSidebar exact path={RoutesApp.Home.path} component={Home} />
            <RouteWithSidebar exact path={RoutesApp.Tables.path} component={Tables} />
            <RouteWithSidebar exact path={RoutesApp.TestTables.path} component={TestTables} />
        </Switch>
    )
}

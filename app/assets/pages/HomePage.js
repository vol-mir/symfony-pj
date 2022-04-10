import React from 'react'
import { Routes, Route } from 'react-router-dom'
import { RoutesApp } from '../routes'

// components
// import Sidebar from '../components/Sidebar'
import Navbar from '../components/Navbar'
import Preloader from '../components/Preloader'
import Footer from '../components/Footer'

// pages
import Home from './Home'
import About from './About'
import Tables from './tables/BootstrapTables'
import TestTables from './tables/TestTables'

class HomePage extends React.Component {
    constructor (props) {
        super(props)
        this.state = {
            loaded: false
        }
    }

    setLoaded = (flag) => {
        this.timer = setInterval(
            () => this.setState(prevState => ({ loaded: flag })),
            1000
        )
    }

    componentDidMount () {
        this.setLoaded(true)
    }

    componentDidUpdate () {
        this.setLoaded(true)
    }

    render () {
        const { loaded } = this.state

        return (
            <div className="App">
                <Preloader show={!loaded} />
                {/* <Sidebar /> */}

                <main className="content">
                    <Navbar />
                    <Routes>
                        <Route exact path={RoutesApp.About.path} element={<About />} />
                        <Route exact path={RoutesApp.Home.path} element={<Home />} />
                        <Route exact path={RoutesApp.Tables.path} element={<Tables />} />
                        <Route exact path={RoutesApp.TestTables.path} element={<TestTables />} />
                    </Routes>
                    <Footer />
                </main>

            </div>
        )
    }
}

export default HomePage

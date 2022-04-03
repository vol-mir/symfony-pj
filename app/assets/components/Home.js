import React, { Component } from 'react'
import { Route, Routes, BrowserRouter as Router, Navigate, Link } from 'react-router-dom'
import News from './News'

class Home extends Component {
    render () {
        return (
            <Router>
                <div>
                    <nav className='navbar navbar-expand-lg navbar-dark bg-dark'>
                        <Link className={'navbar-brand'} to={'/'}> Symfony React Project </Link>
                        <div className='collapse navbar-collapse' id='navbarText'>
                            <ul className='navbar-nav mr-auto'>
                                <li className='nav-item'>
                                    <Link className={'nav-link'} to={'/news'}> News </Link>
                                </li>
                            </ul>
                        </div>
                    </nav>
                    <Routes>
                        <Route exact path='/' element={<Navigate replace to='/news' />} />
                        <Route path='/news' element={ <News/> } />
                    </Routes>
                </div>
            </Router>
        )
    }
}

export default Home

import React from 'react'
import { Routes, Route, Link } from 'react-router-dom'
import './App.css'

class Home extends React.Component {
    render () {
        return (
            <main>
                <h2>Welcome to the homepage!</h2>
                <Link to="/">Home</Link>
                <Link to="/about">About</Link>
            </main>
        )
    }
}

class About extends React.Component {
    render () {
        return (
            <main>
                <h2>Who are we?</h2>
                <Link to="/">Home</Link>
                <Link to="/about">About</Link>
            </main>
        )
    }
}
class App extends React.Component {
    render () {
        return (
            <div className="App">
                <h1>Welcome to React Router!</h1>
                <Routes>
                    <Route path="/" element={ <Home /> } />
                    <Route path="/about" element={ <About /> } />
                </Routes>
            </div>
        )
    }
}

export default App

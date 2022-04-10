import React from 'react'
import { Link } from 'react-router-dom'

class Home extends React.Component {
    render () {
        return (
            <main>
                <h2>Home page :)</h2>
                <Link to="/">Invoices</Link>
                <Link to="/about">Expenses</Link>
                <Link to="/tables">Invoices</Link>
                <Link to="/testtables">Expenses</Link>
            </main>
        )
    }
}

export default Home

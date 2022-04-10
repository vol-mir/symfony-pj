import React from 'react'
// import { Add } from './components/Add'
import { News } from './components/News'
import { Download } from './components/Download'
import './App.css'
import CamelCaseKey from 'camelcase-keys'

class App extends React.Component {
    state = {
        news: null,
        isLoading: false
    }

    static getDerivedStateFromProps (props, state) {
        let nextFilteredNews

        if (Array.isArray(state.news)) {
            nextFilteredNews = [...state.news]

            nextFilteredNews.forEach((item, index) => {
                if (item.fullText.toLowerCase().indexOf('pubg') !== -1) {
                    item.fullText = 'СПАМ'
                }
            })

            return {
                filteredNews: nextFilteredNews
            }
        }

        return null
    }

    componentDidMount () {
        this.setState({ isLoading: true })
        fetch('/api/news')
            .then(response => {
                return response.json()
            })
            .then(data => {
                setTimeout(() => {
                    this.setState({ isLoading: false, news: CamelCaseKey(data) })
                }, 1000)
            })
    }

    // handleAddNews = data => {
    //     const nextNews = [data, ...this.state.news]
    //     this.setState({ news: nextNews })
    // }

    render () {
        const { news, isLoading } = this.state

        return (
            <React.Fragment>
                {/* <Add onAddNews={this.handleAddNews} /> */}
                <Download />
                <h3>Новости</h3>
                {isLoading && <p>Загружаю...</p>}
                {Array.isArray(news) && <News data={news} />}
            </React.Fragment>
        )
    }
}

export default App

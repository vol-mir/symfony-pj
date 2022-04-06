import React from 'react'
import PropTypes from 'prop-types'

class Article extends React.Component {
    state = {
        visible: false
    }

    handleReadMoreClck = e => {
        e.preventDefault()
        this.setState({ visible: true })
    }

    render () {
        const { author, fullText } = this.props.data
        const { visible } = this.state
        return (
            <div className="article">
                <p className="news__author">{author}:</p>
                <p className="news__text">{fullText.length < 150 ? `${fullText}` : `${fullText.substring(0, 150)}...`}</p>
                {!visible && (
                    <a
                        onClick={this.handleReadMoreClck}
                        href="#readmore"
                        className="news__readmore"
                    >
                        Подробнее
                    </a>
                )}
                {visible && <p className="news__big-text">{fullText}</p>}
            </div>
        )
    }
}

Article.propTypes = {
    data: PropTypes.shape({
        id: PropTypes.string.isRequired, // добавили id, это число, обязательно
        author: PropTypes.string.isRequired,
        fullText: PropTypes.string.isRequired
    })
}

export { Article }

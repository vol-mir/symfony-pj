import React from 'react'

class Download extends React.Component {
    onBtnClickHandler = e => {
        e.preventDefault()
        fetch('/api/download/rbc/news')
            .then(response => {
                return response.json()
            })
            .then(data => {
                setTimeout(() => {
                    console.log(data)
                }, 1000)
            })
    }

    render () {
        return (
            <form className="download">
                <button
                    className="add__btn"
                    onClick={this.onBtnClickHandler}
                >
                    Загрузить новости с RBC
                </button>
            </form>
        )
    }
}

export { Download }

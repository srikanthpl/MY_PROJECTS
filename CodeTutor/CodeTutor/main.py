from flask import Flask, request, jsonify
import openai
import os

app = Flask(__name__)

# Set up the OpenAI key
openai.api_key = os.getenv('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')

@app.route('/')
def home():
    return app.send_static_file('index.html')

@app.route('/conversation', methods=['POST'])
def conversation():
    data = request.get_json()
    selected_language = data['language']
    user_message = data['message']

    prompt = f"You are an expert in {selected_language}. Tutor for kids. Respond to: '{user_message}'. Include explanations, suggestions, and practice questions."

    try:
        response = generate_ai_response(prompt)
        if 'choices' in response and response['choices']:
            ai_response = response['choices'][0]['text'].strip()
            return jsonify({'answer': ai_response})
        else:
            return jsonify({'error': 'Unexpected response format from AI', 'response': str(response)})
    except Exception as e:
        return jsonify({'error': str(e)})

def generate_ai_response(prompt):
    try:
        response = openai.Completion.create(
            engine='text-davinci-003',
            prompt=prompt,
            max_tokens=150,
            n=1,
            stop=None,
            temperature=0.7
        )
        print("Full Response from OpenAI: ", response)  # Print the full response
        return response
    except Exception as e:
        app.logger.error(f"Error in generating AI response: {e}")
        return None

if __name__ == '__main__':
    app.run(debug=True)

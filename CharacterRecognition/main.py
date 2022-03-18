import numpy as np, scipy.special, matplotlib.pyplot

a = 2 # sepal_length
b = 2 # sepal_width
c = 2 # petal_length
d = 2 # petal_width 

data_file = open("mnist_train_100.csv", "r")
data_list = data_file.readlines()
data_file.close()

all_values = data_list[0].split(",")
image_array = np.asfarray(all_values[1:]).reshape(28,28)
matplotlib.pyplot.imshow(image_array, cmap='Greys', interpolation='None')

scaled_input = (np.asfarray(all_values[1:]) / 255.0 * 0.99 ) + 0.01
print(scaled_input)

input = np.array([a, b, c, d])


matrix = np.array([[1,2,3,4], [5,6,7,8], [9,10,11,12]])

print(np.dot(matrix, input))

# neural network class definition (until page 136)
class neuralNetwork:

    # initialize the neural network
    def __init__(self, inputnodes, hiddennotes, outputnodes, learning_rate):
        # set number of nodes in each input, hidden, output layer
        self.inodes = inputnodes
        self.hnodes = hiddennotes
        self.onodes = outputnodes

        # link weight matrices, wih and who
        self.wih = np.random.normal(0.0, pow(self.hnodes, -0.5), (self.hnodes, self.inodes))
        self.who = np.random.normal(0.0, pow(self.onodes, -0.5), (self.onodes, self.hnodes))

        # learning rate
        self.lr = learning_rate

        # activation function is the sigmoid function
        self.activation_function = lambda x: scipy.special.expit(x)

        pass

    # train the neural network
    def train(self, inputs_list, targets_list):
        # convert inputs list to 2d array
        inputs = np.array(inputs_list, ndmin=2).T
        targets = np.array(targets_list, ndmin=2).T

        # calculate signals into hidden layer
        hidden_inputs = np.dot(self.wih, inputs)
        # calculate the signals emerging from hidden layer
        hidden_outputs = self.activation_function(hidden_inputs)

        # calculate signals into final output layer
        final_inputs = np.dot(self.who, hidden_outputs)
        # calculate the signals into final output layer
        final_outputs = self.activation_function(final_inputs)

        # output layer error is the (target - actual)
        output_errors = targets - final_outputs
        # hidden layer error is the ouput_errors, split by wight, recombined at hidden nodes
        hidden_errors = np.dot(self.who.T, output_errors)

        # update the weight for the links between the hidden and output layers
        self.who += self.lr * np.dot((output_errors * final_outputs * (1.0 - final_outputs)), np.transpose(hidden_outputs))

        # update the weights for the links between the input and hidden layers
        self.wih += self.lr * np.dot((output_errors * hidden_outputs * (1.0 - hidden_outputs)), np.transpose(inputs))

        pass

    # query the neural network
    def query():
        # convert inputs list to 2d array
        inputs = np.array(inputs_list, ndmin=2).T

        # calculate signals into hidden layer
        hidden_inputs = np.dot(self.wih, inputs)
        # calculate the signals emerging from hidden layer
        hidden_outputs = self.activation_function(hidden_inputs)

        # calculate signals into final output layer
        final_inputs = np.dot(self.who, hidden_outputs)
        # calculate the signals into final output layer
        final_outputs = self.activation_function(final_inputs)

        return final_outputs

# number of input, hidden, output nodes
input_nodes = 784
hidden_nodes = 100
output_nodes = 10

# learning rate is 0.3
learning_rate = 0.3

# create instance of neural network
n = neuralNetwork(input_nodes, hidden_nodes, output_nodes, learning_rate)

# train neural network

## go through all records in the training
for record in data_list:
    # split record by commas
    all_values = record.split(',')
    # scale and shift the inputs
    inputs = (np.asarray(all_values[1:]) / 255.0 * 0.99) + 0.01

    targets = np.zeros(output_nodes) + 0.01

    targets[int(all_values[0])] = 0.99

    n.train(inputs, targets)
    pass

# https://github.com/makeyourownneuralnetwork/makeyourownneuralnetwork/